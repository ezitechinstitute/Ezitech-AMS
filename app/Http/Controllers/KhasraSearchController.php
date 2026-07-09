<?php

namespace App\Http\Controllers;

use App\Models\RealEstateField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KhasraSearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('realEstate.khasraSearch.index');
    }

    // AJAX endpoint - sirf matching khasra return karega
    public function data(Request $request)
    {
        $query = $request->get('q');

        $fields = RealEstateField::with(['mouza', 'kiwat'])
            ->where('created_by', Auth::user()->creatorId())
            ->when($query, function ($q) use ($query) {
                $q->where('field_number', 'like', "%{$query}%");
            })
            ->limit(50)
            ->get();

        $result = $fields->map(function ($f) {
            return [
                'id'            => $f->id,
                'mouza_id'      => $f->mouza_id,
                'mouza_name'    => $f->mouza->name ?? '-',
                'kiwat_number'  => $f->kiwat->kiwat_number ?? '-',
                'field_number'  => $f->field_number,
                'seller_name'   => $f->seller_name,
                'area'          => $f->area_quantity . ' ' . $f->area_unit,
                'status'        => $f->status,
            ];
        });

        return response()->json($result);
    }
}
