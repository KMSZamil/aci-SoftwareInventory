<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Status;
use App\Models\Project;
use App\Models\Platform;
use App\Models\Developer;
use App\Models\TimeFrame;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Exports\ProjectsExport;
use App\Models\SoftwarePlatform;
use App\Models\SoftwareDeveloper;
use App\Models\SoftwareDepartment;
use App\Models\ProjectModification;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['permission:Project']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->ToDate);
        $FromDate = $request->FromDate ?: '1900-01-01'; // date('Y-m-01');
        $TtoDate = ($request->ToDate == null) ? date('Y-m-d') : $request->ToDate;
        $ToDate = $TtoDate . ' 23:59:59';
        //dd($ToDate);
        //$data = Project::with('platforms.platform_name', 'departments.department_name', 'developers.developer_name')->whereBetween('EntryDate', [$FromDate, $ToDate])->get();
        // return $data;
        if ($request->ajax()) {
            $data = Project::with('platforms.platform_name', 'departments.department_name', 'developers.developer_name')->whereBetween('EntryDate', [$FromDate, $ToDate])->get();
            return Datatables::of($data)
                ->addColumn('Status', function ($row) {
                    if ($row->StatusID == 4) {
                        return '<span  class="badge badge-pill badge-success">Complete</span>';
                    } elseif ($row->StatusID == 3) {
                        return '<span  class="badge badge-pill badge-warning">Pipeline</span>';
                    } elseif ($row->StatusID == 2) {
                        return '<span  class="badge badge-pill badge-primary">In Progress</span>';
                    } else {
                        return '<span  class="badge badge-pill badge-secondary">New</span>';
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
                ->addColumn('ImplementationDate', function ($row) {
                    return (($row->ImplementationDate == '1970-01-01 00:00:00.000') || ($row->ImplementationDate == null)) ? '' : date("Y-m-d", strtotime($row->ImplementationDate));
                })
                ->addColumn('EntryDate', function ($row) {
                    return (($row->EntryDate != '1970-01-01 00:00:00.000') || ($row->EntryDate != null)) ? '' : date("Y-m-d", strtotime($row->EntryDate));
                })
                ->addColumn('Description', function ($row) {
                    return isset($row->Description) ? \Str::limit($row->Description, 50, '...') : '';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    $buttons .= '<a href="' . route('projects.show', $row->SoftwareID) . '"> <button class="btn btn-warning btn-xs">Show</button> </a>';
                    $buttons .= '<a href="' . route('projects.edit', $row->SoftwareID) . '"> <button class="btn btn-info btn-xs">Edit</button> </a>';
                    //$buttons .= '<button class="btn btn-danger btn-xs" onclick="deleteConfirmation(' . $row->SoftwareID . ')">Delete</button>';
                    return $buttons;
                })
                ->rawColumns(['action', 'Status'])
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
        $time_frame = TimeFrame::where('Active', 'Y')->get();
        //dd($departments);
        return view('projects.create', compact('status', 'platform', 'developers', 'departments', 'time_frame'));
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

        //dd($SoftwareID);
        $duplicate = Project::where('SoftwareName', $request->SoftwareName)->first();

        //dd($duplicate);
        if ($duplicate == null) {
            $project = new Project();
            $SoftwareID = get_software_id();
            //dd($SoftwareID);
            $project->SoftwareID = $SoftwareID;
        } else {
            $project =  Project::where('SoftwareID', $duplicate->SoftwareID)->first();
            $SoftwareID = $project->SoftwareID;
            Toastr::warning('This project already exists', 'Warning', ["positionClass" => "toast-top-right"]);
            return redirect()->route('projects.show', $project->SoftwareID);
        }

        $project->SoftwareName = isset($request->SoftwareName) ? $request->SoftwareName : '';
        $project->Description = isset($request->Description) ? $request->Description : '';
        $project->Unit = "D";
        $project->NumberOfUser = isset($request->NumberOfUser) ? $request->NumberOfUser : '';
        $project->ImplementationDate = isset($request->ImplementationDate) ? date("Y-m-d", strtotime($request->ImplementationDate)) : null;
        $project->ContactPerson = isset($request->ContactPerson) ? $request->ContactPerson : '';
        $project->StatusID = isset($request->StatusID) ? $request->StatusID : '';
        $project->Value = isset($request->Value) ? $request->Value : 0;
        $project->TimeFrameID = isset($request->TimeFrameID) ? $request->TimeFrameID : 0;

        // added by Mahbub for modification of create
        $project->DeliveryDate = isset($request->DeliveryDate) ? date("Y-m-d", strtotime($request->DeliveryDate)) : null;
        $project->AreaOfConcern = isset($request->AreaOfConcern) ? $request->AreaOfConcern : '';
        $project->Benefit = isset($request->Benefit) ? $request->Benefit : '';
        $project->ImpactArea = isset($request->ImpactArea) ? $request->ImpactArea : 0;

        $project->EntryBy = Auth::user()->UserID;
        //dd($project->save());
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

        if (Auth::user()->UserID == '123456') {
            return redirect()->route('projects.index');
        } else {
            return redirect()->route('my_project.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        $status = Status::all();
        $platform = Platform::all();
        $developers = Developer::all();
        $departments = Department::all();
        $time_frame = TimeFrame::where('Active', 'Y')->get();

        $user_platform = SoftwarePlatform::where('SoftwareID', $project->SoftwareID)->get();
        $user_developers = SoftwareDeveloper::where('SoftwareID', $project->SoftwareID)->get();
        $user_departments = SoftwareDepartment::where('SoftwareID', $project->SoftwareID)->get();
        //added by Mahbub
        $software_modification = ProjectModification::where('SoftwareID', $project->SoftwareID)->get();

        // dd($software_modification);        


        return view('projects.show', compact('project', 'status', 'platform', 'developers', 'departments', 'time_frame', 'user_platform', 'user_developers', 'user_departments'));
    }

    public function edit(Project $project)
    {
        $status = Status::all();
        $platform = Platform::all();
        $developers = Developer::all();
        $departments = Department::all();
        $time_frame = TimeFrame::where('Active', 'Y')->get();

        $user_platform = SoftwarePlatform::where('SoftwareID', $project->SoftwareID)->get();
        $user_developers = SoftwareDeveloper::where('SoftwareID', $project->SoftwareID)->get();
        $user_departments = SoftwareDepartment::where('SoftwareID', $project->SoftwareID)->get();

        return view('projects.edit', compact('project', 'status', 'platform', 'developers', 'departments', 'time_frame', 'user_platform', 'user_developers', 'user_departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project, ProjectModification $projectModification)
    {
        // dd($request->all());
        $this->validate($request, [
            'SoftwareName' => 'required',
            'SoftwarePlatform' => 'required',
            'StatusID' => 'required'
        ]);

        $project = Project::where('SoftwareID', $project->SoftwareID)->first();
        $SoftwareID = $project->SoftwareID;
        $project->SoftwareName = isset($request->SoftwareName) ? $request->SoftwareName : '';
        $project->Description = isset($request->Description) ? $request->Description : '';
        $project->Unit = "D";
        $project->NumberOfUser = isset($request->NumberOfUser) ? $request->NumberOfUser : '';
        $project->ImplementationDate = isset($request->ImplementationDate) ? date("Y-m-d", strtotime($request->ImplementationDate)) : null;
        $project->ContactPerson = isset($request->ContactPerson) ? $request->ContactPerson : '';
        $project->StatusID = isset($request->StatusID) ? $request->StatusID : '';
        $project->Value = isset($request->Value) ? $request->Value : 0;
        $project->TimeFrameID = isset($request->TimeFrameID) ? $request->TimeFrameID : 0;

        // added by Mahbub
        $project->DeliveryDate = isset($request->DeliveryDate) ? date("Y-m-d", strtotime($request->DeliveryDate)) : null;
        $project->AreaOfConcern = isset($request->AreaOfConcern) ? $request->AreaOfConcern : '';
        $project->Benefit = isset($request->Benefit) ? $request->Benefit : '';
        $project->ImpactArea = isset($request->ImpactArea) ? $request->ImpactArea : 0;


        $project->EntryBy = Auth::user()->UserID;
        if ($project->save() == true) {

            // project modification list added with date here
            for ($i = 0; $i < count($request->Modification); $i++) { //Modification is the key that comes with request
                $ProjectModification = new ProjectModification();
                $ProjectModification->SoftwareID = $SoftwareID;
                $ProjectModification->ModificationDetail = $request->Modification[$i];
                $ProjectModification->ModificationDate =   Carbon::now()->toDateString();
                $ProjectModification->updated_at =   Carbon::now()->toDateString();
                $ProjectModification->created_at =   Carbon::now()->toDateString();
                $ProjectModification->save();
            }

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

    public function project_export()
    {
        //$temp = Excel::download(new ProjectsExport, 'project_export.xlsx');
        //dd($temp);
        return \Maatwebsite\Excel\Facades\Excel::download(new ProjectsExport, 'projects_export.xlsx');
        //return $temp;
    }
}
