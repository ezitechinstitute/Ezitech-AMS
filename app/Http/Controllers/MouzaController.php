<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Mouza;
use App\Models\RealEstateField;
use App\Models\PatwariExpense;
use App\Models\RealEstateDocument;
use App\Models\Utility;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MouzaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ===================== MOUZA CRUD =====================

    public function index()
    {
        $mouzas = Mouza::where('created_by', Auth::user()->creatorId())
            ->withCount(['fields', 'availableFields', 'soldFields'])
            ->get();

        return view('realEstate.mouza.index', compact('mouzas'));
    }

    public function create()
    {
        return view('realEstate.mouza.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'district'  => 'nullable|string|max:255',
            'tehsil'    => 'nullable|string|max:255',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Mouza::create([
            'name'        => $request->name,
            'district'    => $request->district,
            'tehsil'      => $request->tehsil,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'description' => $request->description,
            'created_by'  => Auth::user()->creatorId(),
        ]);

        return redirect()->route('mouza.index')->with('success', __('Mouza created successfully.'));
    }

    public function show($id)
    {
        $mouza  = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        $fields = RealEstateField::where('mouza_id', $id)->where('created_by', Auth::user()->creatorId())->get();

        // Map data for Google Maps
        $mapFields = $fields->map(function ($f) {
            return [
                'id'           => $f->id,
                'lat'          => $f->latitude,
                'lng'          => $f->longitude,
                'status'       => $f->status,
                'field_number' => $f->field_number,
                'intiqal_no'   => $f->intiqal_no,
                'seller_name'  => $f->seller_name,
                'area'         => $f->area_quantity . ' ' . $f->area_unit,
                'amount'       => number_format($f->amount, 2),
            ];
        });

        return view('realEstate.mouza.show', compact('mouza', 'fields', 'mapFields'));
    }

    public function edit($id)
    {
        $mouza = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        return view('realEstate.mouza.edit', compact('mouza'));
    }

    public function update(Request $request, $id)
    {
        $mouza = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $mouza->update([
            'name'        => $request->name,
            'district'    => $request->district,
            'tehsil'      => $request->tehsil,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'description' => $request->description,
        ]);

        return redirect()->route('mouza.index')->with('success', __('Mouza updated successfully.'));
    }

    public function destroy($id)
    {
        $mouza = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        $mouza->delete();
        return redirect()->route('mouza.index')->with('success', __('Mouza deleted successfully.'));
    }

    // ===================== KHAIT (FIELD) CRUD =====================

    public function fieldCreate($mouza_id)
    {
        $mouza        = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($mouza_id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        return view('realEstate.field.create', compact('mouza', 'bankAccounts'));
    }

    public function fieldStore(Request $request, $mouza_id)
    {
        $request->validate([
            'field_number' => 'required|unique:real_estate_fields,field_number',
            'seller_name'  => 'required|string|max:255',
            'area_quantity'=> 'required',
            'amount'       => 'required|numeric',
        ]);

        $field = RealEstateField::create([
            'mouza_id'           => $mouza_id,
            'field_number'       => $request->field_number,
            'intiqal_no'         => $request->intiqal_no,
            'area_quantity'      => $request->area_quantity,
            'area_unit'          => $request->area_unit ?? 'Marla',
            'amount'             => $request->amount,
            'status'             => $request->status ?? 'available',
            'latitude'           => $request->latitude,
            'longitude'          => $request->longitude,
            'seller_name'        => $request->seller_name,
            'seller_cnic'        => $request->seller_cnic,
            'seller_phone'       => $request->seller_phone,
            'seller_address'     => $request->seller_address,
            'seller_father_name' => $request->seller_father_name,
            'agent_name'         => $request->agent_name,
            'agent_cnic'         => $request->agent_cnic,
            'agent_phone'        => $request->agent_phone,
            'agent_address'      => $request->agent_address,
            'agent_commission'   => $request->agent_commission ?? 0,
            'patwari_total'      => $request->patwari_total ?? 0,
            'bank_account_id'    => $request->bank_account_id,
            'notes'              => $request->notes,
            'created_by'         => Auth::user()->creatorId(),
        ]);

        // Save Patwari Expense Breakdown
        if ($request->patwari_person && is_array($request->patwari_person)) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    PatwariExpense::create([
                        'model_type'  => 'field',
                        'model_id'    => $field->id,
                        'person_name' => $person,
                        'amount'      => $request->patwari_amount[$i] ?? 0,
                        'note'        => $request->patwari_note[$i] ?? null,
                        'created_by'  => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        // Save Documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $i => $file) {
                $path = $file->store('real-estate/documents', 'public');
                RealEstateDocument::create([
                    'model_type'    => 'field',
                    'model_id'      => $field->id,
                    'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                    'document_path' => $path,
                    'document_type' => $request->document_types[$i] ?? null,
                    'created_by'    => Auth::user()->creatorId(),
                ]);
            }
        }

        return redirect()->route('mouza.show', $mouza_id)->with('success', __('Khait (Field) added successfully.'));
    }

    public function fieldShow($id)
    {
        $field    = RealEstateField::with(['mouza', 'bankAccount', 'patwariExpenses', 'documents'])
            ->where('created_by', Auth::user()->creatorId())
            ->findOrFail($id);
        return view('realEstate.field.show', compact('field'));
    }

    public function fieldEdit($id)
    {
        $field        = RealEstateField::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        $mouzas       = Mouza::where('created_by', Auth::user()->creatorId())->get();
        return view('realEstate.field.edit', compact('field', 'bankAccounts', 'mouzas'));
    }

    public function fieldUpdate(Request $request, $id)
    {
        $field = RealEstateField::where('created_by', Auth::user()->creatorId())->findOrFail($id);

        $field->update([
            'field_number'       => $request->field_number,
            'intiqal_no'         => $request->intiqal_no,
            'area_quantity'      => $request->area_quantity,
            'area_unit'          => $request->area_unit ?? 'Marla',
            'amount'             => $request->amount,
            'status'             => $request->status,
            'latitude'           => $request->latitude,
            'longitude'          => $request->longitude,
            'seller_name'        => $request->seller_name,
            'seller_cnic'        => $request->seller_cnic,
            'seller_phone'       => $request->seller_phone,
            'seller_address'     => $request->seller_address,
            'seller_father_name' => $request->seller_father_name,
            'agent_name'         => $request->agent_name,
            'agent_cnic'         => $request->agent_cnic,
            'agent_phone'        => $request->agent_phone,
            'agent_address'      => $request->agent_address,
            'agent_commission'   => $request->agent_commission ?? 0,
            'patwari_total'      => $request->patwari_total ?? 0,
            'bank_account_id'    => $request->bank_account_id,
            'notes'              => $request->notes,
        ]);

        // Re-save patwari breakdown
        PatwariExpense::where('model_type', 'field')->where('model_id', $id)->delete();
        if ($request->patwari_person && is_array($request->patwari_person)) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    PatwariExpense::create([
                        'model_type'  => 'field',
                        'model_id'    => $field->id,
                        'person_name' => $person,
                        'amount'      => $request->patwari_amount[$i] ?? 0,
                        'note'        => $request->patwari_note[$i] ?? null,
                        'created_by'  => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        // New documents upload
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $i => $file) {
                $path = $file->store('real-estate/documents', 'public');
                RealEstateDocument::create([
                    'model_type'    => 'field',
                    'model_id'      => $field->id,
                    'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                    'document_path' => $path,
                    'document_type' => $request->document_types[$i] ?? null,
                    'created_by'    => Auth::user()->creatorId(),
                ]);
            }
        }

        return redirect()->route('mouza.show', $field->mouza_id)->with('success', __('Khait updated successfully.'));
    }

    public function fieldDestroy($id)
    {
        $field = RealEstateField::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        $mouza_id = $field->mouza_id;
        PatwariExpense::where('model_type', 'field')->where('model_id', $id)->delete();
        RealEstateDocument::where('model_type', 'field')->where('model_id', $id)->delete();
        $field->delete();
        return redirect()->route('mouza.show', $mouza_id)->with('success', __('Khait deleted successfully.'));
    }

    // Delete a single document
    public function deleteDocument($id)
    {
        $doc = RealEstateDocument::findOrFail($id);
        Storage::disk('public')->delete($doc->document_path);
        $doc->delete();
        return back()->with('success', __('Document deleted.'));
    }
}
