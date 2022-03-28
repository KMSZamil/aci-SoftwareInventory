<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Developer;
use App\Models\Platform;
use App\Models\Project;
use App\Models\SoftwareDepartment;
use App\Models\SoftwareDeveloper;
use App\Models\SoftwarePlatform;
use App\Models\Status;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Project']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$data = Project::with('platforms.platform_name', 'departments.department_name', 'developers.developer_name')->get();
        //dd($data);
        if ($request->ajax()) {
            $data = Project::query()->with('platforms.platform_name', 'departments.department_name', 'developers.developer_name');
            return Datatables::of($data)
                ->addColumn('Status', function ($row) {
                    if ($row->StatusID == 4) {
                        return '<span  class="badge badge-pill badge-success">Complete</span>';
                    } elseif ($row->StatusID == 3) {
                        return '<span  class="badge badge-pill badge-warning">Pipeline</span>';
                    } elseif ($row->StatusID == 2) {
                        return '<span  class="badge badge-pill badge-primary">In Progress</span>';
                    } else {
                        return '<span  class="badge badge-pill badge-secondary">In Progress</span>';
                    }
                })
                ->addColumn('platform_name', function ($row) {
                    $sub = '';
                    if (count($row->platforms) > 0) {
                        for ($i = 0; $i < count($row->platforms); $i++) {
                            if ($i == count($row->platforms) - 1) {
                                $sub .= $row->platforms[$i]->platform_name->PlatformName;
                            } else {
                                $sub .= $row->platforms[$i]->platform_name->PlatformName . ', ';
                            }
                        }
                    }
                    return $sub;
                })
                ->addColumn('developer_name', function ($row) {
                    $sub = '';
                    if (count($row->developers) > 0) {
                        for ($i = 0; $i < count($row->developers); $i++) {
                            if ($i == count($row->developers) - 1) {
                                $sub .= $row->developers[$i]->developer_name->DeveloperName;
                            } else {
                                $sub .= $row->developers[$i]->developer_name->DeveloperName . ', ';
                            }
                        }
                    }
                    return $sub;
                })
                ->addColumn('department_name', function ($row) {
                    $sub = '';
                    if (count($row->departments) > 0) {
                        for ($i = 0; $i < count($row->departments); $i++) {
                            if ($i == count($row->departments) - 1) {
                                $sub .= $row->departments[$i]->department_name->DepartmentName;
                            } else {
                                $sub .= $row->departments[$i]->department_name->DepartmentName . ', ';
                            }
                        }
                    }
                    return $sub;
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    //$buttons .= '<a href="' . route('projects.show', $row->SoftwareID) . '"> <button class="btn btn-warning btn-xs">Show</button> </a>';
                    $buttons .= '<a href="' . route('projects.edit', $row->SoftwareID) . '"> <button class="btn btn-info btn-xs">Edit</button> </a>';
                    //$buttons .= '<button class="btn btn-danger btn-xs" onclick="deleteConfirmation(' . $row->SoftwareID . ')">Delete</button>';
                    return $buttons;
                })
                ->rawColumns(['action', 'Status', 'platform_name', 'developer_name', 'department_name'])
                ->make(true);
        }
        return view('projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $status = Status::all();
        $platform = Platform::all();
        $developers = Developer::all();
        $departments = Department::all();
        //dd($departments);
        return view('projects.create', compact('status', 'platform', 'developers', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'SoftwareName' => 'required',
            'SoftwarePlatform' => 'required',
            'StatusID' => 'required'
        ]);

        $SoftwareID = get_software_id();
        //dd($SoftwareID);

        $project = new Project();
        $project->SoftwareID = $SoftwareID;
        $project->SoftwareName = $request->SoftwareName;
        $project->Description = $request->Description;
        $project->Unit = "D";
        $project->StatusID = $request->StatusID;
        if ($project->save() == true) {
            for ($i = 0; $i < count($request->SoftwarePlatform); $i++) {
                $software_platform = new SoftwarePlatform();
                $software_platform->SoftwareID = $SoftwareID;
                $software_platform->PlatformID = $request->SoftwarePlatform[$i];
                $software_platform->save();
            }
            for ($i = 0; $i < count($request->SoftwareDepartment); $i++) {
                $software_department = new SoftwareDepartment();
                $software_department->SoftwareID = $SoftwareID;
                $software_department->DepartmentCode = $request->SoftwareDepartment[$i];
                //print_r($software_department);
                $software_department->save();
            }
            for ($i = 0; $i < count($request->SoftwareDeveloper); $i++) {
                $software_developer = new SoftwareDeveloper();
                $software_developer->SoftwareID = $SoftwareID;
                $software_developer->DeveloperID = $request->SoftwareDeveloper[$i];
                //($software_developer);
                $software_developer->save();
            }
            //exit();

            Toastr::success('Data added successfully', 'GoodJob!', ["positionClass" => "toast-top-right"]);
        } else {
            Toastr::error('Data not inserted', 'Opps!', ["positionClass" => "toast-top-right"]);
        }
        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $status = Status::all();
        $platform = Platform::all();
        $developers = Developer::all();
        $departments = Department::all();

        $user_platform = SoftwarePlatform::where('SoftwareID', $project->SoftwareID)->get();
        $user_developers = SoftwareDeveloper::where('SoftwareID', $project->SoftwareID)->get();
        $user_departments = SoftwareDepartment::where('SoftwareID', $project->SoftwareID)->get();

        return view('projects.edit', compact('project', 'status', 'platform', 'developers', 'departments', 'user_platform', 'user_developers', 'user_departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        $this->validate($request, [
            'SoftwareName' => 'required',
            'SoftwarePlatform' => 'required',
            'StatusID' => 'required'
        ]);

        $project = Project::where('SoftwareID', $project->SoftwareID)->first();
        $SoftwareID = $project->SoftwareID;
        $project->SoftwareName = $request->SoftwareName;
        $project->Description = $request->Description;
        $project->Unit = "D";
        $project->StatusID = $request->StatusID;
        if ($project->save() == true) {
            SoftwarePlatform::where('SoftwareID', $SoftwareID)->delete();
            for ($i = 0; $i < count($request->SoftwarePlatform); $i++) {
                $software_platform = new SoftwarePlatform();
                $software_platform->SoftwareID = $SoftwareID;
                $software_platform->PlatformID = $request->SoftwarePlatform[$i];
                $software_platform->save();
            }
            SoftwareDepartment::where('SoftwareID', $SoftwareID)->delete();
            for ($i = 0; $i < count($request->SoftwareDepartment); $i++) {
                $software_department = new SoftwareDepartment();
                $software_department->SoftwareID = $SoftwareID;
                $software_department->DepartmentCode = $request->SoftwareDepartment[$i];
                //print_r($software_department);
                $software_department->save();
            }
            SoftwareDeveloper::where('SoftwareID', $SoftwareID)->delete();
            for ($i = 0; $i < count($request->SoftwareDeveloper); $i++) {
                $software_developer = new SoftwareDeveloper();
                $software_developer->SoftwareID = $SoftwareID;
                $software_developer->DeveloperID = $request->SoftwareDeveloper[$i];
                //($software_developer);
                $software_developer->save();
            }
            Toastr::success('Data updated successfully', 'GoodJob!', ["positionClass" => "toast-top-right"]);
        } else {
            Toastr::error('Data not updated', 'Opps!', ["positionClass" => "toast-top-right"]);
        }
        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return array
     */
    public function destroy(Project $project)
    {
        if ($project->delete()) {
            $data = array(
                'success' => true,
                'message' => 'Project deleted successfully.'
            );
        } else {
            $data = array(

                'success' => false,
                'message' => 'Project delete unsuccessful.'
            );
        }
        return $data;
    }
}
