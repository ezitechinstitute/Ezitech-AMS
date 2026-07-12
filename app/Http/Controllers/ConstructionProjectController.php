<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\ConstructionField;
use App\Models\ConstructionPlot;
use App\Models\ConstructionProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConstructionProjectController extends Controller
{
    // ===================== PROJECT CRUD =====================

    public function index()
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        $projects = ConstructionProject::where('created_by', Auth::user()->creatorId())->get();
        return view('constructionProject.index', compact('projects'));
    }

    public function create()
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        return view('constructionProject.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()->with('error', $validator->getMessageBag()->first());

        $project = new ConstructionProject();
        $project->name             = $request->name;
        $project->district         = $request->district;
        $project->tehsil           = $request->tehsil;
        $project->latitude         = $request->latitude;
        $project->longitude        = $request->longitude;
        $project->intiqal_number   = $request->intiqal_number;
        $project->intiqal_date     = $request->intiqal_date;
        $project->total_area       = $request->total_area;
        $project->total_area_unit  = $request->total_area_unit;
        $project->description      = $request->description;
        $project->created_by       = Auth::user()->creatorId();
        $project->save();

        return redirect()->route('construction-project.show', $project->id)
            ->with('success', __('Project successfully created.'));
    }

    public function show($id)
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        $project  = ConstructionProject::findOrFail($id);
        $fields   = ConstructionField::where('construction_project_id', $id)->get();
        $plots    = ConstructionPlot::where('construction_project_id', $id)->get();
        $mapFields = $fields->map(function ($f) {
            return [
                'lat'          => $f->latitude,
                'lng'          => $f->longitude,
                'field_number' => $f->field_number,
                'intiqal_no'   => $f->intiqal_no,
                'seller_name'  => $f->seller_name,
                'area'         => $f->area_quantity . ' ' . $f->area_unit,
                'amount'       => number_format($f->amount, 2),
                'status'       => $f->status,
            ];
        });

        return view('constructionProject.show', compact('project', 'fields', 'plots', 'mapFields'));
    }

    public function edit($id)
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        $project = ConstructionProject::findOrFail($id);
        return view('constructionProject.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        $project = ConstructionProject::findOrFail($id);
        $project->name             = $request->name;
        $project->district         = $request->district;
        $project->tehsil           = $request->tehsil;
        $project->latitude         = $request->latitude;
        $project->longitude        = $request->longitude;
        $project->intiqal_number   = $request->intiqal_number;
        $project->intiqal_date     = $request->intiqal_date;
        $project->total_area       = $request->total_area;
        $project->total_area_unit  = $request->total_area_unit;
        $project->description      = $request->description;
        $project->save();

        return redirect()->route('construction-project.show', $project->id)
            ->with('success', __('Project successfully updated.'));
    }

    public function destroy($id)
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        ConstructionProject::findOrFail($id)->delete();
        return redirect()->route('construction-project.index')
            ->with('success', __('Project successfully deleted.'));
    }

    // ===================== FIELD CRUD =====================

    public function fieldCreate($project_id)
    {
        $project      = ConstructionProject::findOrFail($project_id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        return view('constructionProject.field.create', compact('project', 'bankAccounts'));
    }

    public function fieldStore(Request $request, $project_id)
    {
        $validator = Validator::make($request->all(), [
            'field_number' => 'required|unique:construction_fields,field_number',
            'seller_name'  => 'required',
            'area_quantity' => 'required',
            'amount'       => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput()
                ->with('error', $validator->getMessageBag()->first());

        $field = new ConstructionField();
        $field->construction_project_id = $project_id;
        $field->field_number     = $request->field_number;
        $field->intiqal_no       = $request->intiqal_no;
        $field->area_quantity    = $request->area_quantity;
        $field->area_unit        = $request->area_unit;
        $field->area_acre        = $request->area_acre ?? 0;
        $field->area_kanal       = $request->area_kanal ?? 0;
        $field->area_marla       = $request->area_marla ?? 0;
        $field->amount           = $request->amount ?? 0;
        $field->status           = $request->status ?? 'available';
        $field->latitude         = $request->latitude;
        $field->longitude        = $request->longitude;
        $field->seller_name      = $request->seller_name;
        $field->seller_cnic      = $request->seller_cnic;
        $field->seller_phone     = $request->seller_phone;
        $field->seller_address   = $request->seller_address;
        $field->seller_father_name = $request->seller_father_name;
        $field->agent_name       = $request->agent_name;
        $field->agent_cnic       = $request->agent_cnic;
        $field->agent_phone      = $request->agent_phone;
        $field->agent_address    = $request->agent_address;
        $field->agent_commission = $request->agent_commission ?? 0;
        $field->patwari_total    = $request->patwari_total ?? 0;
        $field->bank_account_id  = $request->bank_account_id;
        $field->notes            = $request->notes;
        $field->created_by       = Auth::user()->creatorId();
        $field->save();

        // Patwari Breakdown save karo
        if ($request->patwari_person) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    \App\Models\PatwariExpense::create([
                        'model_type'  => 'construction_field',
                        'model_id'    => $field->id,
                        'person_name' => $person,
                        'amount'      => $request->patwari_amount[$i] ?? 0,
                        'note'        => $request->patwari_note[$i] ?? '',
                        'created_by'  => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        // Documents save karo
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $i => $file) {
                if ($file) {
                    $path = $file->store('construction/documents', 'public');
                    \App\Models\RealEstateDocument::create([
                        'model_type'    => 'construction_field',
                        'model_id'      => $field->id,
                        'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                        'document_path' => $path,
                        'document_type' => $request->document_types[$i] ?? '',
                        'created_by'    => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        return redirect()->route('construction-project.show', $project_id)
            ->with('success', __('Field successfully added.'));
    }


    public function fieldEdit($id)
    {
        $field        = ConstructionField::findOrFail($id);
        $project      = ConstructionProject::findOrFail($field->construction_project_id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        return view('constructionProject.field.edit', compact('field', 'project', 'bankAccounts'));
    }

    public function fieldUpdate(Request $request, $id)
    {
        $field = ConstructionField::findOrFail($id);
        $field->field_number       = $request->field_number;
        $field->intiqal_no         = $request->intiqal_no;
        $field->area_quantity      = $request->area_quantity;
        $field->area_unit          = $request->area_unit;
        $field->area_acre          = $request->area_acre ?? 0;
        $field->area_kanal         = $request->area_kanal ?? 0;
        $field->area_marla         = $request->area_marla ?? 0;
        $field->amount             = $request->amount ?? 0;
        $field->status             = $request->status;
        $field->latitude           = $request->latitude;
        $field->longitude          = $request->longitude;
        $field->seller_name        = $request->seller_name;
        $field->seller_cnic        = $request->seller_cnic;
        $field->seller_phone       = $request->seller_phone;
        $field->seller_address     = $request->seller_address;
        $field->seller_father_name = $request->seller_father_name;
        $field->agent_name         = $request->agent_name;
        $field->agent_cnic         = $request->agent_cnic;
        $field->agent_phone        = $request->agent_phone;
        $field->agent_address      = $request->agent_address;
        $field->agent_commission   = $request->agent_commission ?? 0;
        $field->patwari_total      = $request->patwari_total ?? 0;
        $field->bank_account_id    = $request->bank_account_id;
        $field->notes              = $request->notes;
        $field->save();

        // Patwari Breakdown — purani delete karke nai save karo
        \App\Models\PatwariExpense::where('model_type', 'construction_field')
            ->where('model_id', $field->id)->delete();

        if ($request->patwari_person) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    \App\Models\PatwariExpense::create([
                        'model_type'  => 'construction_field',
                        'model_id'    => $field->id,
                        'person_name' => $person,
                        'amount'      => $request->patwari_amount[$i] ?? 0,
                        'note'        => $request->patwari_note[$i] ?? '',
                        'created_by'  => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        // Documents — naye add karo (purane raho)
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $i => $file) {
                if ($file) {
                    $path = $file->store('construction/documents', 'public');
                    \App\Models\RealEstateDocument::create([
                        'model_type'    => 'construction_field',
                        'model_id'      => $field->id,
                        'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                        'document_path' => $path,
                        'document_type' => $request->document_types[$i] ?? '',
                        'created_by'    => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        return redirect()->route('construction-project.show', $field->construction_project_id)
            ->with('success', __('Field successfully updated.'));
    }

    public function fieldDestroy($id)
    {
        $field      = ConstructionField::findOrFail($id);
        $project_id = $field->construction_project_id;
        $field->delete();
        return redirect()->route('construction-project.show', $project_id)
            ->with('success', __('Field successfully deleted.'));
    }
    // Agricultural Land Index (all fields)
    public function fieldIndex()
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        $fields = ConstructionField::where('created_by', Auth::user()->creatorId())->get();
        return view('constructionProject.field.index', compact('fields'));
    }

    // Plots Index (all plots)
    public function plotIndex()
    {
        if (!Auth::user()->can('manage construction project'))
            return redirect()->back()->with('error', __('Permission denied.'));

        $plots = ConstructionPlot::where('created_by', Auth::user()->creatorId())->get();
        return view('constructionProject.plot.index', compact('plots'));
    }

    // ===================== PLOT CRUD =====================

    public function plotCreate($project_id)
    {
        $project      = ConstructionProject::findOrFail($project_id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        return view('constructionProject.plot.create', compact('project', 'bankAccounts'));
    }

    public function plotStore(Request $request, $project_id)
    {
        $validator = Validator::make($request->all(), [
            'field_number'   => 'required|unique:construction_plots,field_number',
            'purchaser_name' => 'required',
            'area_quantity'  => 'required',
            'amount'         => 'required',
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput()
                ->with('error', $validator->getMessageBag()->first());

        $plot = new ConstructionPlot();
        $plot->construction_project_id  = $project_id;
        $plot->field_number             = $request->field_number;
        $plot->intiqal_no               = $request->intiqal_no;
        $plot->area_quantity            = $request->area_quantity;
        $plot->area_unit                = $request->area_unit;
        $plot->amount                   = $request->amount ?? 0;
        $plot->status                   = $request->status ?? 'available';
        $plot->latitude                 = $request->latitude;
        $plot->longitude                = $request->longitude;
        $plot->purchaser_name           = $request->purchaser_name;
        $plot->purchaser_cnic           = $request->purchaser_cnic;
        $plot->purchaser_phone          = $request->purchaser_phone;
        $plot->purchaser_address        = $request->purchaser_address;
        $plot->purchaser_father_name    = $request->purchaser_father_name;
        $plot->agent_name               = $request->agent_name;
        $plot->agent_cnic               = $request->agent_cnic;
        $plot->agent_phone              = $request->agent_phone;
        $plot->agent_address            = $request->agent_address;
        $plot->agent_commission         = $request->agent_commission ?? 0;
        $plot->patwari_total            = $request->patwari_total ?? 0;
        $plot->bank_account_id          = $request->bank_account_id;
        $plot->notes                    = $request->notes;
        $plot->created_by               = Auth::user()->creatorId();
        $plot->save();

        // Patwari Breakdown
        if ($request->patwari_person) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    \App\Models\PatwariExpense::create([
                        'model_type'  => 'construction_plot',
                        'model_id'    => $plot->id,
                        'person_name' => $person,
                        'amount'      => $request->patwari_amount[$i] ?? 0,
                        'note'        => $request->patwari_note[$i] ?? '',
                        'created_by'  => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        // Documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $i => $file) {
                if ($file) {
                    $path = $file->store('construction/documents', 'public');
                    \App\Models\RealEstateDocument::create([
                        'model_type'    => 'construction_plot',
                        'model_id'      => $plot->id,
                        'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                        'document_path' => $path,
                        'document_type' => $request->document_types[$i] ?? '',
                        'created_by'    => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        return redirect()->route('construction-project.show', $project_id)
            ->with('success', __('Plot successfully added.'));
    }
    public function plotEdit($id)
    {
        $plot         = ConstructionPlot::findOrFail($id);
        $project      = ConstructionProject::findOrFail($plot->construction_project_id);
        $bankAccounts = BankAccount::where('created_by', Auth::user()->creatorId())->get();
        return view('constructionProject.plot.edit', compact('plot', 'project', 'bankAccounts'));
    }

    public function plotUpdate(Request $request, $id)
    {
        $plot = ConstructionPlot::findOrFail($id);
        $plot->field_number          = $request->field_number;
        $plot->intiqal_no            = $request->intiqal_no;
        $plot->area_quantity         = $request->area_quantity;
        $plot->area_unit             = $request->area_unit;
        $plot->amount                = $request->amount ?? 0;
        $plot->status                = $request->status;
        $plot->latitude              = $request->latitude;
        $plot->longitude             = $request->longitude;
        $plot->purchaser_name        = $request->purchaser_name;
        $plot->purchaser_cnic        = $request->purchaser_cnic;
        $plot->purchaser_phone       = $request->purchaser_phone;
        $plot->purchaser_address     = $request->purchaser_address;
        $plot->purchaser_father_name = $request->purchaser_father_name;
        $plot->agent_name            = $request->agent_name;
        $plot->agent_cnic            = $request->agent_cnic;
        $plot->agent_phone           = $request->agent_phone;
        $plot->agent_address         = $request->agent_address;
        $plot->agent_commission      = $request->agent_commission ?? 0;
        $plot->patwari_total         = $request->patwari_total ?? 0;
        $plot->bank_account_id       = $request->bank_account_id;
        $plot->notes                 = $request->notes;
        $plot->save();

        // Patwari — purani delete, nai save
        \App\Models\PatwariExpense::where('model_type', 'construction_plot')
            ->where('model_id', $plot->id)->delete();

        if ($request->patwari_person) {
            foreach ($request->patwari_person as $i => $person) {
                if (!empty($person)) {
                    \App\Models\PatwariExpense::create([
                        'model_type'  => 'construction_plot',
                        'model_id'    => $plot->id,
                        'person_name' => $person,
                        'amount'      => $request->patwari_amount[$i] ?? 0,
                        'note'        => $request->patwari_note[$i] ?? '',
                        'created_by'  => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        // Documents — naye add karo
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $i => $file) {
                if ($file) {
                    $path = $file->store('construction/documents', 'public');
                    \App\Models\RealEstateDocument::create([
                        'model_type'    => 'construction_plot',
                        'model_id'      => $plot->id,
                        'document_name' => $request->document_names[$i] ?? $file->getClientOriginalName(),
                        'document_path' => $path,
                        'document_type' => $request->document_types[$i] ?? '',
                        'created_by'    => Auth::user()->creatorId(),
                    ]);
                }
            }
        }

        return redirect()->route('construction-project.show', $plot->construction_project_id)
            ->with('success', __('Plot successfully updated.'));
    }

    public function plotDestroy($id)
    {
        $plot       = ConstructionPlot::findOrFail($id);
        $project_id = $plot->construction_project_id;
        $plot->delete();
        return redirect()->route('construction-project.show', $project_id)
            ->with('success', __('Plot successfully deleted.'));
    }
}
