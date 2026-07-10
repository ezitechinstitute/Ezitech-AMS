<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Kiwat;
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

    // public function create(Request $request)
    // {
    //     $mouzas = Mouza::where('created_by', Auth::user()->creatorId())->get();

    //     // Mouza page ke "Add Plot" button se aya ho to pre-select
    //     $mouza = $request->mouza_id ? Mouza::find($request->mouza_id) : null;

    //     // Kiwat dropdown - agar mouza pre-selected hai to us mouza ke Kiwats hi load karo
    //     $kiwats = $request->mouza_id
    //         ? Kiwat::where('mouza_id', $request->mouza_id)->where('created_by', Auth::user()->creatorId())->get()
    //         : collect();

    //     $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();

    //     return view('realEstate.plot.create', compact('mouzas', 'mouza', 'kiwats', 'bankAccounts'));
    // }
    public function create(Request $request)
    {
        $mouzas = Mouza::where('created_by', Auth::user()->creatorId())->get();
        $mouza = $request->mouza_id ? Mouza::find($request->mouza_id) : null;

        $kiwats = $request->mouza_id
            ? Kiwat::where('mouza_id', $request->mouza_id)->where('created_by', Auth::user()->creatorId())->get()
            : collect();

        // Naya: Khasra dropdown (agar kiwat pre-selected ho)
        $khasras = $request->kiwat_id
            ? \App\Models\RealEstateField::where('kiwat_id', $request->kiwat_id)->where('created_by', Auth::user()->creatorId())->get()
            : collect();

        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();

        return view('realEstate.plot.create', compact('mouzas', 'mouza', 'kiwats', 'khasras', 'bankAccounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mouza_id'       => 'required|exists:mouzas,id',
            'kiwat_id'       => 'required|exists:kiwats,id',
            'intiqal_no'     => 'nullable|string|max:255',
            'amount'         => 'required|numeric',
            'purchaser_name' => 'required|string|max:255',
            'khasra_id' => 'nullable|exists:real_estate_fields,id',

            'fields'                    => 'required|array|min:1',
            'fields.*.field_number'     => 'required|string|distinct|unique:plots,field_number',
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
        ]);

        // Make sure the chosen Kiwat actually belongs to the chosen Mouza
        $kiwat = Kiwat::where('id', $request->kiwat_id)
            ->where('mouza_id', $request->mouza_id)
            ->firstOrFail();

        $createdPlots = [];
        $anySold      = false;

        foreach ($request->fields as $fieldData) {
            $plot = Plot::create([
                'mouza_id'              => $request->mouza_id,
                'kiwat_id'              => $kiwat->id,
                'field_number'          => $fieldData['field_number'],
                'intiqal_no'            => $request->intiqal_no,
                'khasra_id' => $fieldData['khasra_id'] ?? $request->khasra_id ?? null,

                // Normalized total (in Marla)
                'area_quantity'         => $fieldData['total_marla'],
                'area_unit'             => 'Marla',

                // Original breakdown, so receipts/prints can show "5 Kanal 10 Marla"
                'area_acre'             => $fieldData['area_acre'] ?? 0,
                'area_kanal'            => $fieldData['area_kanal'] ?? 0,
                'area_marla'            => $fieldData['area_marla'] ?? 0,

                'amount'                => $request->amount,
                'status'                => $fieldData['status'] ?? 'available',
                'latitude'              => $fieldData['latitude'] ?? null,
                'longitude'             => $fieldData['longitude'] ?? null,

                // Shared Intiqal-level data, copied onto every plot row
                'purchaser_name'        => $request->purchaser_name,
                'purchaser_cnic'        => $request->purchaser_cnic,
                'purchaser_phone'       => $request->purchaser_phone,
                'purchaser_address'     => $request->purchaser_address,
                'purchaser_father_name' => $request->purchaser_father_name,
                'agent_name'            => $request->agent_name,
                'agent_cnic'            => $request->agent_cnic,
                'agent_phone'           => $request->agent_phone,
                'agent_address'         => $request->agent_address,
                'agent_commission'      => $request->agent_commission ?? 0,
                'patwari_total'         => $request->patwari_total ?? 0,
                'bank_account_id'       => $request->bank_account_id,
                'notes'                 => $request->notes,
                'created_by'            => Auth::user()->creatorId(),
            ]);

            $createdPlots[] = $plot;

            if ($plot->status == 'sold') {
                $anySold = true;
            }
        }

        // Patwari expense breakdown and Supporting Documents are Intiqal-level
        // (not per plot), so they are linked to the first plot created.
        // All plots sharing the same intiqal_no can be looked up together.
        $primaryPlot = $createdPlots[0];

        if ($request->patwari_person && is_array($request->patwari_person)) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    PatwariExpense::create([
                        'model_type'  => 'plot',
                        'model_id'    => $primaryPlot->id,
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
                    'model_id'      => $primaryPlot->id,
                    'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                    'document_path' => $path,
                    'document_type' => $request->document_types[$i] ?? null,
                    'created_by'    => Auth::user()->creatorId(),
                ]);
            }
        }

        // ===== IMPORTANT: transactions are recorded ONCE for the whole deal,
        // never looped per plot, otherwise the amount would be double/triple
        // counted in the bank ledger when a single Intiqal has multiple fields. =====

        $fieldNumbersList = collect($createdPlots)->pluck('field_number')->implode(', ');

        if ($anySold) {
            $this->recordPlotTransaction(
                $primaryPlot,
                $request->bank_account_id,
                (float) $request->amount,
                'credit',
                'Plot Sale',
                'Plot sale - Field #' . $fieldNumbersList . ' to ' . $request->purchaser_name
            );
        }

        $this->recordPlotTransaction(
            $primaryPlot,
            $request->bank_account_id,
            (float) $request->agent_commission,
            'debit',
            'Agent Commission',
            'Commission - ' . ($request->agent_name ?? '') . ' (Field #' . $fieldNumbersList . ')'
        );

        $this->recordPlotTransaction(
            $primaryPlot,
            $request->bank_account_id,
            (float) $request->patwari_total,
            'debit',
            'Patwari Expense',
            'Patwari expenses (Field #' . $fieldNumbersList . ')'
        );

        $count = count($createdPlots);

        return redirect()->route('plot.index')->with('success', $count > 1
            ? "{$count} Plots added successfully under Kiwat {$kiwat->kiwat_number} / Intiqal No. {$request->intiqal_no}."
            : __('Plot added successfully.'));
    }

    public function show($id)
    {
        $plot = Plot::with(['bankAccount', 'patwariExpenses', 'documents', 'kiwat', 'mouza'])
            ->where('created_by', Auth::user()->creatorId())
            ->findOrFail($id);
        return view('realEstate.plot.show', compact('plot'));
    }

    public function edit($id)
    {
        $plot         = Plot::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        $mouzas       = Mouza::where('created_by', Auth::user()->creatorId())->get();
        $kiwats       = Kiwat::where('mouza_id', $plot->mouza_id)
            ->where('created_by', Auth::user()->creatorId())
            ->get();

        return view('realEstate.plot.edit', compact('plot', 'bankAccounts', 'mouzas', 'kiwats'));
    }

    public function update(Request $request, $id)
    {
        $plot = Plot::where('created_by', Auth::user()->creatorId())->findOrFail($id);

        $request->validate([
            'mouza_id' => 'required|exists:mouzas,id',
            'kiwat_id' => 'required|exists:kiwats,id',
        ]);

        // Make sure the chosen Kiwat actually belongs to the chosen Mouza
        Kiwat::where('id', $request->kiwat_id)
            ->where('mouza_id', $request->mouza_id)
            ->firstOrFail();

        $plot->update([
            'mouza_id'              => $request->mouza_id,
            'kiwat_id'              => $request->kiwat_id,
            'field_number'          => $request->field_number,
            'intiqal_no'            => $request->intiqal_no,
            'area_acre'             => $request->area_acre ?? 0,
            'area_kanal'            => $request->area_kanal ?? 0,
            'area_marla'            => $request->area_marla ?? 0,
            'area_quantity'         => $request->area_quantity,
            'area_unit'             => $request->area_unit ?? 'Marla',
            'amount'                => $request->amount,
            'status'                => $request->status,
            'latitude'              => $request->latitude,
            'longitude'             => $request->longitude,
            'purchaser_name'        => $request->purchaser_name,
            'purchaser_cnic'        => $request->purchaser_cnic,
            'purchaser_phone'       => $request->purchaser_phone,
            'purchaser_address'     => $request->purchaser_address,
            'purchaser_father_name' => $request->purchaser_father_name,
            'agent_name'            => $request->agent_name,
            'agent_cnic'            => $request->agent_cnic,
            'agent_phone'           => $request->agent_phone,
            'agent_address'         => $request->agent_address,
            'agent_commission'      => $request->agent_commission ?? 0,
            'patwari_total'         => $request->patwari_total ?? 0,
            'bank_account_id'       => $request->bank_account_id,
            'notes'                 => $request->notes,
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
            ->get(['id', 'field_number', 'purchaser_name', 'area_quantity', 'area_unit', 'amount', 'status', 'latitude', 'longitude', 'intiqal_no', 'kiwat_id']);

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
    public function khasrasByKiwat($kiwat_id)
    {
        $khasras = \App\Models\RealEstateField::where('kiwat_id', $kiwat_id)
            ->where('created_by', Auth::user()->creatorId())
            ->get(['id', 'field_number', 'seller_name', 'status']);

        return response()->json($khasras);
    }



// ============================================================
//  Add these 3 methods inside your existing PlotController
// ============================================================

    /**
     * Page 1: Area list — sab Mouza jinme plots hain, plot counts ke saath.
     */
    public function inventory()
    {
        $mouzas = Mouza::where('created_by', Auth::user()->creatorId())
            ->withCount([
                'plots',
                'plots as available_plots_count' => function ($q) {
                    $q->where('status', 'available');
                },
                'plots as sold_plots_count' => function ($q) {
                    $q->where('status', 'sold');
                },
            ])
            ->having('plots_count', '>', 0)   // sirf wo areas jinme plots hain
            ->get();

        return view('realEstate.plot.inventory', compact('mouzas'));
    }

    /**
     * Page 2: Ek area (Mouza) ke plots + Leaflet map.
     * Table + search bar + map ek hi page pe.
     */
    public function inventoryArea($mouza_id)
    {
        $mouza = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($mouza_id);

        $plots = Plot::where('mouza_id', $mouza_id)
            ->where('created_by', Auth::user()->creatorId())
            ->with('kiwat')
            ->get();

        // Map ke liye — sirf wo plots jinki location set hai
        $mapPlots = $plots->map(function ($p) {
            return [
                'id'           => $p->id,
                'lat'          => $p->latitude,
                'lng'          => $p->longitude,
                'status'       => $p->status,
                'field_number' => $p->field_number,
                'kiwat_number' => $p->kiwat->kiwat_number ?? '-',
                'purchaser'    => $p->purchaser_name,
                'area'         => $p->area_quantity . ' ' . $p->area_unit,
                'amount'       => number_format($p->amount, 2),
            ];
        })->values();

        return view('realEstate.plot.inventoryArea', compact('mouza', 'plots', 'mapPlots'));
    }

    /**
     * AJAX: search within a single area's plots (field_number / purchaser).
     */
    public function inventoryData(Request $request, $mouza_id)
    {
        $query = $request->get('q');

        $plots = Plot::where('mouza_id', $mouza_id)
            ->where('created_by', Auth::user()->creatorId())
            ->with('kiwat')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('field_number', 'like', "%{$query}%")
                        ->orWhere('purchaser_name', 'like', "%{$query}%")
                        ->orWhere('intiqal_no', 'like', "%{$query}%");
                });
            })
            ->limit(100)
            ->get();

        $result = $plots->map(function ($p) {
            return [
                'id'           => $p->id,
                'field_number' => $p->field_number,
                'kiwat_number' => $p->kiwat->kiwat_number ?? '-',
                'intiqal_no'   => $p->intiqal_no ?? '-',
                'purchaser'    => $p->purchaser_name,
                'area'         => $p->area_quantity . ' ' . $p->area_unit,
                'amount'       => number_format($p->amount, 2),
                'status'       => $p->status,
                'lat'          => $p->latitude,
                'lng'          => $p->longitude,
            ];
        });

        return response()->json($result);
    }
}
