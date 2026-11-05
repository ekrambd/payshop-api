<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Services\Slider\SliderService;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use DataTables;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(
        protected SliderService $sliderService
    ){
        $this->middleware('auth_check');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $sliders = $this->sliderService->fetch()->latest()->get();

            return Datatables::of($sliders)
                ->addIndexColumn()


                ->addColumn('status', function ($row) {

                    $checked = $row->status === 'Active' ? 'checked' : '';

                    $class = $row->status === 'Active'
                        ? 'active-slider'
                        : 'decline-slider';

                    return '
                        <label class="switch">
                            <input 
                                type="checkbox"
                                class="' . $class . '"
                                id="status-slider-update"
                                data-id="' . $row->id . '"
                                ' . $checked . '
                            >
                            <span class="slider round"></span>
                        </label>
                    ';
                })

                // ================= IMAGE =================
                ->addColumn('image', function ($row) {

                    return '
                        <img src="' . asset('uploads/sliders/' . $row->image) . '"
                            alt="slider image"
                            class="img-fluid"
                            style="width:80px;height:50px;object-fit:cover;border-radius:5px;">
                    ';
                })


                ->addColumn('action', function ($row) {

                    $editUrl = route('sliders.show', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm action-button edit-slider" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="#" class="btn btn-danger btn-sm delete-slider action-button" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })

                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }

        return view('admin.sliders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSliderRequest $request)
    {
        try
        {
            $slider = $this->sliderService->store($request->all());
        
            $notification=array(
                'messege'=>$slider?successMessage("slider","add"):errorMessage("slider","update"),
                'alert-type'=>$slider?"success":"error",
            );

            return redirect()->back()->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        try
        {
            $slider = $this->sliderService->update($request->all(), $slider);
        
            $notification=array(
                'messege'=>$slider?successMessage("slider","update"):errorMessage("slider","update"),
                'alert-type'=>$slider?"success":"error",
            );

            return redirect('/sliders')->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        try
        {
            $slider = $this->sliderService->delete($slider);
        
            if(!$slider){
                return response()->json(['status'=>false, 'message'=>errorMessage("slider","delete")],403);
            }
            return response()->json(['status'=>true, 'message'=>successMessage("slider","delete")],200);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function sliderStatusUpdate(Request $request)
    {
        try
        {   
            $slider = $this->sliderService->fetch()->where('id',$request->slider_id)->first();
            $slider = $this->sliderService->statusUpdate(
                $slider,
                $request->status
            );

            return response()->json([
                'status' => true,
                'message' => "Successfully updated",
                'data' => $slider
            ]);
            
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
