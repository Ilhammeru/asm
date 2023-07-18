<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = __('global.categories');
        return view('master.division.index', compact('pageTitle'));
    }

    public function ajax()
    {
        $data = Division::get();
        $data = set_collection_key($data);

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return view('master.division.action', compact('row'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = view('master.division.create')->render();

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
                Rule::unique('divisions', 'name'),
            ],
        ]);
        if ($validator->fails()) {
            return $this->validationErrors($validator);
        }
        Division::create(['name' => $request->name]);

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
        $data = Division::find($id);
        $view = view('master.division.edit', compact('data'))->render();

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
                Rule::unique('divisions', 'name')->ignore($id),
            ],
        ]);
        if ($validator->fails()) {
            return $this->validationErrors($validator);
        }
        Division::where('id', $id)->update(['name' => $request->name]);

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
        $data = Division::find($id);
        $data->delete();

        return $this->success(__('global.success_delete_unit'));
    }
}
