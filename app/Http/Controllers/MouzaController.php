<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Kiwat;
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
            ->withCount(['fields', 'availableFields', 'soldFields', 'kiwats'])
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
            'name'                => 'required|string|max:255',
            'district'            => 'nullable|string|max:255',
            'tehsil'              => 'nullable|string|max:255',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'description'         => 'nullable|string',
            'intiqal_number'      => 'nullable|string|max:255',
            'intiqal_date'        => 'nullable|date',
            'area_acre'           => 'nullable|numeric|min:0',
            'area_kanal'          => 'nullable|numeric|min:0',
            'area_marla'          => 'nullable|numeric|min:0',
            'documents.*'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'document_names.*'    => 'nullable|string|max:255',
            'document_types.*'    => 'nullable|string|max:100',
        ]);

        $mouza = Mouza::create([
            'name'             => $request->name,
            'district'         => $request->district,
            'tehsil'           => $request->tehsil,
            'latitude'         => $request->latitude,
            'longitude'        => $request->longitude,
            'description'      => $request->description,
            'intiqal_number'   => $request->intiqal_number,
            'intiqal_date'     => $request->intiqal_date,
            'area_acre'        => $request->area_acre ?? 0,
            'area_kanal'       => $request->area_kanal ?? 0,
            'area_marla'       => $request->area_marla ?? 0,
            'created_by'       => auth()->id(),
        ]);

        // ===== Handle Supporting Documents =====
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                if (!$file) {
                    continue;
                }

                $path = $file->store('mouza-documents', 'public');

                $mouza->documents()->create([
                    'document_name' => $request->document_names[$index] ?? $file->getClientOriginalName(),
                    'document_type' => $request->document_types[$index] ?? null,
                    'document_path' => $path,
                ]);
            }
        }

        return redirect()->route('mouza.index')->with('success', __('Mouza created successfully.'));
    }

    public function show($id)
    {
        $mouza  = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        $fields = RealEstateField::where('mouza_id', $id)->where('created_by', Auth::user()->creatorId())->get();
        $kiwats = Kiwat::where('mouza_id', $id)->where('created_by', Auth::user()->creatorId())
            ->withCount(['plots', 'fields'])->get();

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

        return view('realEstate.mouza.show', compact('mouza', 'fields', 'mapFields', 'kiwats'));
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
            'name'            => 'required|string|max:255',
            'district'        => 'nullable|string|max:255',
            'tehsil'          => 'nullable|string|max:255',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
            'description'     => 'nullable|string',
            'intiqal_number'  => 'nullable|string|max:255',
            'intiqal_date'    => 'nullable|date',
            'area_acre'       => 'nullable|numeric|min:0',
            'area_kanal'      => 'nullable|numeric|min:0',
            'area_marla'      => 'nullable|numeric|min:0',
        ]);

        $mouza->update([
            'name'            => $request->name,
            'district'        => $request->district,
            'tehsil'          => $request->tehsil,
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'description'     => $request->description,
            'intiqal_number'  => $request->intiqal_number,
            'intiqal_date'    => $request->intiqal_date,
            'area_acre'       => $request->area_acre ?? 0,
            'area_kanal'      => $request->area_kanal ?? 0,
            'area_marla'      => $request->area_marla ?? 0,
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

    public function fieldCreate(Request $request, $mouza_id)
    {
        $mouza        = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($mouza_id);
        $kiwats       = Kiwat::where('mouza_id', $mouza_id)->where('created_by', Auth::user()->creatorId())->get();
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        return view('realEstate.field.create', compact('mouza', 'kiwats', 'bankAccounts'));
    }

    public function fieldStore(Request $request, $mouza_id)
    {
        $request->validate([
            'kiwat_id'            => 'required|string',
            'new_kiwat_number'    => 'required_if:kiwat_id,new|nullable|string|max:255|unique:kiwats,kiwat_number,NULL,id,mouza_id,' . $mouza_id,
            'new_kiwat_total_area'      => 'nullable|string|max:50',
            'new_kiwat_total_area_unit' => 'nullable|string|max:50',
            'new_kiwat_description'     => 'nullable|string',
            'intiqal_no'    => 'nullable|string|max:255',
            'amount'        => 'required|numeric',
            'seller_name'   => 'required|string|max:255',

            'fields'                    => 'required|array|min:1',
            'fields.*.field_number'     => 'required|string|distinct|unique:real_estate_fields,field_number',
            'fields.*.status'           => 'nullable|in:available,reserved,sold',
            'fields.*.area_acre'        => 'nullable|numeric|min:0',
            'fields.*.area_kanal'       => 'nullable|numeric|min:0',
            'fields.*.area_marla'       => 'nullable|numeric|min:0',
            'fields.*.total_marla'      => 'required|numeric|min:0.01',
            'fields.*.latitude'         => 'nullable|numeric',
            'fields.*.longitude'        => 'nullable|numeric',
        ], [
            'fields.*.field_number.unique'   => 'Field Number :input already exists.',
            'fields.*.field_number.distinct' => 'Duplicate Field Numbers are not allowed in the same submission.',
            'fields.*.total_marla.required'  => 'Please enter a valid Land Area (Acre/Kanal/Marla) for every field.',
            'kiwat_id.required'              => 'Please select a Kiwat (Block/Phase) for this Mouza.',
            'new_kiwat_number.required_if'   => 'Please enter a number for the new Kiwat.',
            'new_kiwat_number.unique'        => 'This Kiwat number already exists in this Mouza.',
        ]);

        // Kiwat resolve karna — ya to existing select hua, ya naya inline banega
        if ($request->kiwat_id === 'new') {
            $kiwat = Kiwat::create([
                'mouza_id'        => $mouza_id,
                'kiwat_number'    => $request->new_kiwat_number,
                'description'     => $request->new_kiwat_description,
                'total_area'      => $request->new_kiwat_total_area,
                'total_area_unit' => $request->new_kiwat_total_area_unit,
                'created_by'      => Auth::user()->creatorId(),
            ]);
        } else {
            // Make sure the chosen Kiwat actually belongs to this Mouza
            $kiwat = Kiwat::where('id', $request->kiwat_id)
                ->where('mouza_id', $mouza_id)
                ->firstOrFail();
        }

        $createdFields = [];

        foreach ($request->fields as $fieldData) {
            $createdFields[] = RealEstateField::create([
                'mouza_id'           => $mouza_id,
                'kiwat_id'           => $kiwat->id,
                'field_number'       => $fieldData['field_number'],
                'intiqal_no'         => $request->intiqal_no,

                // Normalized total (in Marla) kept in the existing area_quantity/area_unit columns
                'area_quantity'      => $fieldData['total_marla'],
                'area_unit'          => 'Marla',

                // Original breakdown, so receipts/prints can still show "5 Kanal 10 Marla"
                'area_acre'          => $fieldData['area_acre'] ?? 0,
                'area_kanal'         => $fieldData['area_kanal'] ?? 0,
                'area_marla'         => $fieldData['area_marla'] ?? 0,

                'amount'             => $request->amount,
                'status'             => $fieldData['status'] ?? 'available',
                'latitude'           => $fieldData['latitude'] ?? null,
                'longitude'          => $fieldData['longitude'] ?? null,

                // Shared Intiqal-level data, copied onto every field row
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
        }

        // Patwari expense breakdown and Supporting Documents are Intiqal-level
        // (not per field), so they are linked to the first field created.
        // All fields sharing the same intiqal_no can be looked up together.
        $primaryField = $createdFields[0];

        if ($request->patwari_person && is_array($request->patwari_person)) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    PatwariExpense::create([
                        'model_type'  => 'field',
                        'model_id'    => $primaryField->id,
                        'person_name' => $person,
                        'amount'      => $request->patwari_amount[$i] ?? 0,
                        'note'        => $request->patwari_note[$i] ?? null,
                        'created_by'  => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $i => $file) {
                $path = $file->store('real-estate/documents', 'public');
                RealEstateDocument::create([
                    'model_type'    => 'field',
                    'model_id'      => $primaryField->id,
                    'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                    'document_path' => $path,
                    'document_type' => $request->document_types[$i] ?? null,
                    'created_by'    => Auth::user()->creatorId(),
                ]);
            }
        }

        $count = count($createdFields);

        return redirect()->route('mouza.show', $mouza_id)
            ->with('success', $count > 1
                ? "{$count} Fields added successfully under Kiwat {$kiwat->kiwat_number} / Intiqal No. {$request->intiqal_no}."
                : 'Khait (Field) added successfully.');
    }

    public function fieldShow($id)
    {
        $field = RealEstateField::with(['mouza', 'kiwat', 'bankAccount', 'patwariExpenses', 'documents'])
            ->where('created_by', Auth::user()->creatorId())
            ->findOrFail($id);
        return view('realEstate.field.show', compact('field'));
    }

    public function fieldEdit($id)
    {
        $field        = RealEstateField::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        $mouzas       = Mouza::where('created_by', Auth::user()->creatorId())->get();
        $kiwats       = Kiwat::where('mouza_id', $field->mouza_id)
            ->where('created_by', Auth::user()->creatorId())->get();
        return view('realEstate.field.edit', compact('field', 'bankAccounts', 'mouzas', 'kiwats'));
    }

    public function fieldUpdate(Request $request, $id)
    {
        $field = RealEstateField::where('created_by', Auth::user()->creatorId())->findOrFail($id);

        $request->validate([
            'kiwat_id'      => 'required|exists:kiwats,id',
            'field_number'  => 'required|unique:real_estate_fields,field_number,' . $field->id,
            'seller_name'   => 'required|string|max:255',
            'amount'        => 'required|numeric',
            'area_acre'     => 'nullable|numeric|min:0',
            'area_kanal'    => 'nullable|numeric|min:0',
            'area_marla'    => 'nullable|numeric|min:0',
            'area_quantity' => 'required|numeric|min:0.01', // total in Marla, calculated on the frontend
        ]);

        // Make sure the chosen Kiwat belongs to this field's Mouza
        Kiwat::where('id', $request->kiwat_id)
            ->where('mouza_id', $field->mouza_id)
            ->firstOrFail();

        $field->update([
            'kiwat_id'           => $request->kiwat_id,
            'field_number'       => $request->field_number,
            'intiqal_no'         => $request->intiqal_no,

            // Normalized total (in Marla)
            'area_quantity'      => $request->area_quantity,
            'area_unit'          => 'Marla',

            // Original breakdown (Acre / Kanal / Marla), so it can be displayed as entered
            'area_acre'          => $request->area_acre ?? 0,
            'area_kanal'         => $request->area_kanal ?? 0,
            'area_marla'         => $request->area_marla ?? 0,

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
