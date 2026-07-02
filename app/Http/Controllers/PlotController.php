<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Mouza;
use App\Models\PatwariExpense;
use App\Models\Plot;
use App\Models\RealEstateDocument;
use App\Models\Transaction;
use App\Models\Utility;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plots = Plot::where('created_by', Auth::user()->creatorId())->get();
        return view('realEstate.plot.index', compact('plots'));
    }

    // public function create()
    // {
    //     $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
    //     return view('realEstate.plot.create', compact('bankAccounts'));
    // }
    public function create(Request $request)
    {
        $mouzas = Mouza::where('created_by', Auth::user()->creatorId())->get();

        // Mouza page ke "Add Plot" button se aya ho to pre-select
        $mouza = $request->mouza_id ? Mouza::find($request->mouza_id) : null;

        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();

        return view('realEstate.plot.create', compact('mouzas', 'mouza', 'bankAccounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_number'   => 'required|unique:plots,field_number',
            'purchaser_name' => 'required|string|max:255',
            'area_quantity'  => 'required',
            'amount'         => 'required|numeric',
        ]);

        $plot = Plot::create([
            'field_number'         => $request->field_number,
            'intiqal_no'           => $request->intiqal_no,
            'area_quantity'        => $request->area_quantity,
            'area_unit'            => $request->area_unit ?? 'Marla',
            'amount'               => $request->amount,
            'status'               => $request->status ?? 'available',
            'latitude'             => $request->latitude,
            'longitude'            => $request->longitude,
            'purchaser_name'       => $request->purchaser_name,
            'purchaser_cnic'       => $request->purchaser_cnic,
            'purchaser_phone'      => $request->purchaser_phone,
            'purchaser_address'    => $request->purchaser_address,
            'purchaser_father_name' => $request->purchaser_father_name,
            'agent_name'           => $request->agent_name,
            'agent_cnic'           => $request->agent_cnic,
            'agent_phone'          => $request->agent_phone,
            'agent_address'        => $request->agent_address,
            'agent_commission'     => $request->agent_commission ?? 0,
            'patwari_total'        => $request->patwari_total ?? 0,
            'bank_account_id'      => $request->bank_account_id,
            'notes'                => $request->notes,
            'created_by'           => Auth::user()->creatorId(),
        ]);

        // Patwari Expense Breakdown
        if ($request->patwari_person && is_array($request->patwari_person)) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    PatwariExpense::create([
                        'model_type'  => 'plot',
                        'model_id'    => $plot->id,
                        'person_name' => $person,
                        'amount'      => $request->patwari_amount[$i] ?? 0,
                        'note'        => $request->patwari_note[$i] ?? null,
                        'created_by'  => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        // Documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $i => $file) {
                $path = $file->store('real-estate/documents', 'public');
                RealEstateDocument::create([
                    'model_type'    => 'plot',
                    'model_id'      => $plot->id,
                    'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                    'document_path' => $path,
                    'document_type' => $request->document_types[$i] ?? null,
                    'created_by'    => Auth::user()->creatorId(),
                ]);
            }
        }
        if ($plot->status == 'sold') {
            $this->recordPlotTransaction(
                $plot,
                $request->bank_account_id,
                (float) $plot->amount,
                'credit',
                'Plot Sale',
                'Plot sale - Field #' . $plot->field_number . ' to ' . $plot->purchaser_name
            );
        }

        $this->recordPlotTransaction(
            $plot,
            $request->bank_account_id,
            (float) $request->agent_commission,
            'debit',
            'Agent Commission',
            'Commission - ' . ($request->agent_name ?? '') . ' (Field #' . $plot->field_number . ')'
        );

        $this->recordPlotTransaction(
            $plot,
            $request->bank_account_id,
            (float) $request->patwari_total,
            'debit',
            'Patwari Expense',
            'Patwari expenses (Field #' . $plot->field_number . ')'
        );

        return redirect()->route('plot.index')->with('success', __('Plot added successfully.'));
    }

    public function show($id)
    {
        $plot = Plot::with(['bankAccount', 'patwariExpenses', 'documents'])
            ->where('created_by', Auth::user()->creatorId())
            ->findOrFail($id);
        return view('realEstate.plot.show', compact('plot'));
    }

    public function edit($id)
    {
        $plot         = Plot::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        return view('realEstate.plot.edit', compact('plot', 'bankAccounts'));
    }

    public function update(Request $request, $id)
    {
        $plot = Plot::where('created_by', Auth::user()->creatorId())->findOrFail($id);

        $plot->update([
            'field_number'         => $request->field_number,
            'intiqal_no'           => $request->intiqal_no,
            'area_quantity'        => $request->area_quantity,
            'area_unit'            => $request->area_unit ?? 'Marla',
            'amount'               => $request->amount,
            'status'               => $request->status,
            'latitude'             => $request->latitude,
            'longitude'            => $request->longitude,
            'purchaser_name'       => $request->purchaser_name,
            'purchaser_cnic'       => $request->purchaser_cnic,
            'purchaser_phone'      => $request->purchaser_phone,
            'purchaser_address'    => $request->purchaser_address,
            'purchaser_father_name' => $request->purchaser_father_name,
            'agent_name'           => $request->agent_name,
            'agent_cnic'           => $request->agent_cnic,
            'agent_phone'          => $request->agent_phone,
            'agent_address'        => $request->agent_address,
            'agent_commission'     => $request->agent_commission ?? 0,
            'patwari_total'        => $request->patwari_total ?? 0,
            'bank_account_id'      => $request->bank_account_id,
            'notes'                => $request->notes,
        ]);

        // Re-save patwari breakdown
        PatwariExpense::where('model_type', 'plot')->where('model_id', $id)->delete();
        if ($request->patwari_person && is_array($request->patwari_person)) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    PatwariExpense::create([
                        'model_type'  => 'plot',
                        'model_id'    => $plot->id,
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
                    'model_type'    => 'plot',
                    'model_id'      => $plot->id,
                    'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                    'document_path' => $path,
                    'document_type' => $request->document_types[$i] ?? null,
                    'created_by'    => Auth::user()->creatorId(),
                ]);
            }
        }

        return redirect()->route('plot.show', $id)->with('success', __('Plot updated successfully.'));
    }

    public function destroy($id)
    {
        $plot = Plot::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        PatwariExpense::where('model_type', 'plot')->where('model_id', $id)->delete();
        RealEstateDocument::where('model_type', 'plot')->where('model_id', $id)->delete();
        $plot->delete();
        return redirect()->route('plot.index')->with('success', __('Plot deleted successfully.'));
    }

    // Map data for plots
    public function mapData()
    {
        $plots = Plot::where('created_by', Auth::user()->creatorId())
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'field_number', 'purchaser_name', 'area_quantity', 'area_unit', 'amount', 'status', 'latitude', 'longitude', 'intiqal_no']);

        return response()->json($plots);
    }



    private function recordPlotTransaction($plot, $bankAccountId, $amount, $direction, $category, $description)
    {
        if (!$bankAccountId || $amount <= 0) {
            return;
        }

        // 1. Bank balance update (existing helper)
        Utility::bankAccountBalance($bankAccountId, $amount, $direction);

        // 2. Transaction record (existing model) — Banking reports mein dikhega
        Transaction::addTransaction((object)[
            'account'     => $bankAccountId,
            'user_id'     => $plot->id,
            'user_type'   => 'Plot',           // hamara module identifier
            'type'        => $direction == 'credit' ? 'Plot Sale' : 'Plot Expense',
            'amount'      => $amount,
            'description' => $description,
            'date'        => now()->format('Y-m-d'),
            'created_by'  => $plot->created_by,
            'payment_id'  => $plot->id,
            'category'    => $category,
        ]);
    }
}
