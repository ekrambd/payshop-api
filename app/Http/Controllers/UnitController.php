<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use App\Http\Requests\UpateUnitRequest;
use DataTables;
use App\Services\Unit\UnitService;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(
        protected UnitService $unitService
    ) {
        $this->middleware('auth_check');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $units = $this->unitService->fetch()->latest()->get();

            return DataTables::of($units)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {

                    return '
                    <a href="' . route('units.show', $row->id) . '" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete-unit">
                        <i class="fa fa-trash"></i>
                    </a>
                    ';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.units.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        try
        {
            $this->unitService->store($request->validated());

            $notification=array(
                'messege'=>"Unit added successfully",
                'alert-type'=>"success",
            );

            return redirect()->back()->with($notification);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UpateUnitRequest $request, Unit $unit)
    {
        try
        {
            $this->unitService->update($request->validated(), $unit);

            $notification=array(
                'messege'=>"Unit updated successfully",
                'alert-type'=>"success",
            );

            return redirect('/units')->with($notification);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        try
        {
            $this->unitService->delete($unit);

            return response()->json([
                'status' => true,
                'message' => 'Unit deleted successfully'
            ]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
