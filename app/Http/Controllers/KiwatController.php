<?php

namespace App\Http\Controllers;

use App\Models\Kiwat;
use App\Models\Mouza;
use Auth;
use Illuminate\Http\Request;

class KiwatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List all Kiwats (blocks/phases) under a given Mouza
    public function index($mouza_id)
    {
        $mouza  = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($mouza_id);
        $kiwats = Kiwat::where('mouza_id', $mouza_id)
            ->where('created_by', Auth::user()->creatorId())
            ->withCount(['plots', 'fields', 'availablePlots', 'soldPlots'])
            ->get();

        return view('realEstate.kiwat.index', compact('mouza', 'kiwats'));
    }

    public function create($mouza_id)
    {
        $mouza = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($mouza_id);
        return view('realEstate.kiwat.create', compact('mouza'));
    }

    public function store(Request $request, $mouza_id)
    {
        $mouza = Mouza::where('created_by', Auth::user()->creatorId())->findOrFail($mouza_id);

        $request->validate([
            'kiwat_number'    => 'required|string|max:255|unique:kiwats,kiwat_number,NULL,id,mouza_id,' . $mouza_id,
            'description'     => 'nullable|string',
            'total_area'      => 'nullable|string|max:50',
            'total_area_unit' => 'nullable|string|max:50',
        ], [
            'kiwat_number.unique' => 'This Kiwat number already exists in this Mouza.',
        ]);

        Kiwat::create([
            'mouza_id'        => $mouza_id,
            'kiwat_number'    => $request->kiwat_number,
            'description'     => $request->description,
            'total_area'      => $request->total_area,
            'total_area_unit' => $request->total_area_unit,
            'created_by'      => Auth::user()->creatorId(),
        ]);

        return redirect()->route('mouza.kiwat.index', $mouza_id)
            ->with('success', __('Kiwat added successfully.'));
    }

    // Shows a Kiwat along with all plots/fields grouped under it
    public function show($id)
    {
        $kiwat = Kiwat::with(['mouza', 'plots', 'fields'])
            ->where('created_by', Auth::user()->creatorId())
            ->findOrFail($id);

        return view('realEstate.kiwat.show', compact('kiwat'));
    }

    public function edit($id)
    {
        $kiwat = Kiwat::where('created_by', Auth::user()->creatorId())->findOrFail($id);
        return view('realEstate.kiwat.edit', compact('kiwat'));
    }

    public function update(Request $request, $id)
    {
        $kiwat = Kiwat::where('created_by', Auth::user()->creatorId())->findOrFail($id);

        $request->validate([
            'kiwat_number'    => 'required|string|max:255|unique:kiwats,kiwat_number,' . $id . ',id,mouza_id,' . $kiwat->mouza_id,
            'description'     => 'nullable|string',
            'total_area'      => 'nullable|string|max:50',
            'total_area_unit' => 'nullable|string|max:50',
        ], [
            'kiwat_number.unique' => 'This Kiwat number already exists in this Mouza.',
        ]);

        $kiwat->update([
            'kiwat_number'    => $request->kiwat_number,
            'description'     => $request->description,
            'total_area'      => $request->total_area,
            'total_area_unit' => $request->total_area_unit,
        ]);

        return redirect()->route('mouza.kiwat.index', $kiwat->mouza_id)
            ->with('success', __('Kiwat updated successfully.'));
    }

    public function destroy($id)
    {
        $kiwat = Kiwat::withCount(['plots', 'fields'])
            ->where('created_by', Auth::user()->creatorId())
            ->findOrFail($id);

        // Safety check: don't delete a Kiwat that still has Plots/Fields linked to it
        if ($kiwat->plots_count > 0 || $kiwat->fields_count > 0) {
            return back()->with('error', __('Cannot delete this Kiwat — it still has Plots/Khasra numbers linked to it. Move or delete them first.'));
        }

        $mouza_id = $kiwat->mouza_id;
        $kiwat->delete();

        return redirect()->route('mouza.kiwat.index', $mouza_id)
            ->with('success', __('Kiwat deleted successfully.'));
    }

    // AJAX helper: get Kiwats for a Mouza (used in Plot/Field create-edit dropdowns)
    public function byMouza($mouza_id)
    {
        $kiwats = Kiwat::where('mouza_id', $mouza_id)
            ->where('created_by', Auth::user()->creatorId())
            ->get(['id', 'kiwat_number']);

        return response()->json($kiwats);
    }
}
