<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SampleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Sample']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sample::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status',function($row){
                    return $row->is_active==1 ? '<span  class="badge badge-pill badge-success">Active</span>' : '<span  class="badge badge-pill badge-danger">In-Active</span>';
                })
                ->addColumn('action', function($row){
                    $buttons='';
                    $buttons .= '<a href="'.route('samples.show', $row->id).'"> <button class="btn btn-warning btn-xs">Show</button> </a>';
                    $buttons .= '<a href="'.route('samples.edit', $row->id).'"> <button class="btn btn-info btn-xs">Edit</button> </a>';
                    $buttons .= '<button class="btn btn-danger btn-xs" onclick="deleteConfirmation('.$row->id.')">Delete</button>';
                    return $buttons;

                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('samples.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('samples.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title1' => 'required',
            'title2' => 'required',
            'description' => 'required',
            'is_active' => 'required'
        ]);

        $sample = new Sample();
        $sample->title1 = $request->title1;
        $sample->title2 = $request->title2;
        $sample->description = $request->description;
        $sample->date = $request->date;
        $sample->is_active = $request->is_active;
        $sample->created_by = Auth::user()->name;
        if($sample->save()==true){
            Toastr::success('Data added successfully', 'GoodJob!', ["positionClass" => "toast-top-right"]);
        }else{
            Toastr::error('Data not inserted', 'Opps!', ["positionClass" => "toast-top-right"]);
        }
        return redirect()->route('samples.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sample  $sample
     * @return \Illuminate\Http\Response
     */
    public function show(Sample $sample)
    {
        return view('samples.show',compact('sample'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sample  $sample
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Sample $sample)
    {
        return view('samples.edit',compact('sample'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sample  $sample
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Sample $sample)
    {
        $this->validate($request, [
            'title1' => 'required',
            'title2' => 'required',
            'description' => 'required',
            'is_active' => 'required'
        ]);

        $sample = Sample::find($sample->id);
        $sample->title1 = $request->title1;
        $sample->title2 = $request->title2;
        $sample->description = $request->description;
        $sample->date = $request->date;
        $sample->updated_by = Auth::user()->name;
        if($request->is_active){
            $sample->is_active = $request->is_active;
        }else{
            $sample->is_active = '0';
        }
        if($sample->save()==true){
            Toastr::success('Data updated successfully', 'GoodJob!', ["positionClass" => "toast-top-right"]);
        }else{
            Toastr::error('Data not updated', 'Opps!', ["positionClass" => "toast-top-right"]);
        }
        return redirect()->route('samples.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sample  $sample
     * @return array
     */
    public function destroy(Sample $sample)
    {
        if ($sample->delete()) {
            $data = array(
                'success' => true,
                'message' => 'Sample deleted successfully.'
            );
        } else {
            $data = array(

                'success' => false,
                'message' => 'Sample delete unsuccessful.'
            );
        }
        return $data;
    }
}
