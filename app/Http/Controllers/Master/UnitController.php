<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ItemUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = __('global.unit');
        return view('master.units.index', compact('pageTitle'));
    }

    public function ajax()
    {
        $data = ItemUnit::get();
        $data = set_collection_key($data);

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return view('master.units.action', compact('row'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = view('master.units.create')->render();

        return $this->success('Success', ['view' => $view]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('item_units', 'name'),
            ],
        ]);
        if ($validator->fails()) {
            return $this->validationErrors($validator);
        }
        ItemUnit::create(['name' => $request->name]);

        return $this->success(__('global.success_create_unit'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ItemUnit::find($id);
        $view = view('master.units.edit', compact('data'))->render();

        return $this->success('Success', ['view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('item_units', 'name')->ignore($id),
            ],
        ]);
        if ($validator->fails()) {
            return $this->validationErrors($validator);
        }
        ItemUnit::where('id', $id)->update(['name' => $request->name]);

        return $this->success(__('global.success_update_unit'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /**
         * TODO: Run valiadtion relation
         */
        $data = ItemUnit::find($id);
        $data->delete();

        return $this->success(__('global.success_delete_unit'));
    }
}
