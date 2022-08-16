<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Project;
use App\Models\Platform;
use App\Models\Developer;
use App\Models\TimeFrame;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\SoftwarePlatform;
use App\Exports\MyProjectsExport;
use App\Models\SoftwareDeveloper;
use App\Models\SoftwareDepartment;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MyProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:My Projects']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $UserID = Auth::user()->UserID;
            $UserID = isset($UserID) && $UserID == 123456 ? '%' : $UserID;
            $data = SoftwareDeveloper::where('DeveloperID', 'like', '%' . $UserID . '%')->with('projects.platforms.platform_name', 'projects.departments.department_name', 'projects.developers.developer_name')->get();
            return Datatables::of($data)
                ->addColumn('Status', function ($row) {
                    if ($row->projects->StatusID == 4) {
                        return '<span  class="badge badge-pill badge-success">Complete</span>';
                    } elseif ($row->projects->StatusID == 3) {
                        return '<span  class="badge badge-pill badge-warning">Pipeline</span>';
                    } elseif ($row->projects->StatusID == 2) {
                        return '<span  class="badge badge-pill badge-primary">In Progress</span>';
                    } else {
                        return '<span  class="badge badge-pill badge-secondary">New</span>';
                    }
                })
                ->addColumn('platform_name', function ($row) {
                    $sub = '';
                    if (count($row->projects->platforms) > 0) {
                        for ($i = 0; $i < count($row->projects->platforms); $i++) {
                            if ($i == count($row->projects->platforms) - 1) {
                                $sub .= $row->projects->platforms[$i]->platform_name->PlatformName;
                            } else {
                                $sub .= $row->projects->platforms[$i]->platform_name->PlatformName . ', ';
                            }
                        }
                    }
                    return $sub;
                })
                ->addColumn('developer_name', function ($row) {
                    $sub = '';
                    if (count($row->projects->developers) > 0) {
                        for ($i = 0; $i < count($row->projects->developers); $i++) {
                            if ($i == count($row->projects->developers) - 1) {
                                $sub .= $row->projects->developers[$i]->developer_name->DeveloperName;
                            } else {
                                $sub .= $row->projects->developers[$i]->developer_name->DeveloperName . ', ';
                            }
                        }
                    }
                    return $sub;
                })
                ->addColumn('department_name', function ($row) {
                    $sub = '';
                    if (count($row->projects->departments) > 0) {
                        for ($i = 0; $i < count($row->projects->departments); $i++) {
                            if ($i == count($row->projects->departments) - 1) {
                                $sub .= $row->projects->departments[$i]->department_name->DepartmentName;
                            } else {
                                $sub .= $row->projects->departments[$i]->department_name->DepartmentName . ', ';
                            }
                        }
                    }
                    return $sub;
                })
                ->addColumn('SoftwareName', function ($row) {
                    return $row->projects->SoftwareName;
                })
                ->addColumn('SoftwareName', function ($row) {
                    return isset($row->projects->SoftwareName) ? $row->projects->SoftwareName : '';
                })
                ->addColumn('Description', function ($row) {
                    return isset($row->projects->Description) ? \Str::limit($row->projects->Description, 50, '...') : '';
                })
                ->addColumn('NumberOfUser', function ($row) {
                    return isset($row->projects->NumberOfUser) ? $row->projects->NumberOfUser : '';
                })
                ->addColumn('ImplementationDate', function ($row) {
                    return isset($row->projects->ImplementationDate) ? date("Y-m-d", strtotime($row->projects->ImplementationDate)) : '';
                })
                ->addColumn('ContactPerson', function ($row) {
                    return isset($row->projects->ContactPerson) ? $row->projects->ContactPerson : '';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    //$buttons .= '<a href="' . route('projects.show', $row->SoftwareID) . '"> <button class="btn btn-warning btn-xs">Show</button> </a>';
                    $buttons .= '<a href="' . route('my_project.edit', $row->SoftwareID) . '"> <button class="btn btn-info btn-xs">Edit</button> </a>';
                    $buttons .= '<button class="btn btn-danger btn-xs" onclick="deleteConfirmation(' . $row->SoftwareID . ')">Delete</button>';
                    return $buttons;
                })
                ->rawColumns(['SoftwareName', 'action', 'Description', 'Status', 'platform_name', 'developer_name', 'department_name'])
                ->make(true);
        }
        return view('my_projects.index');
    }


    public function platform_wise(Request $request, $id)
    {
        $PlatformID = $id;

        $UserID = Auth::user()->UserID;
        $UserID = isset($UserID) && $UserID == 123456 ? '%' : $UserID;
        //$data = SoftwarePlatform::where('PlatformID', 'like', '%' . $PlatformID . '%')->with('projects.platforms.platform_name', 'projects.departments.department_name', 'projects.developers.developer_name')->get();
        $data = DB::select("SELECT S.*, P.PlatformName, SS.StatusName
                    FROM SoftwarePlatform SP
                    INNER JOIN Software S ON S.SoftwareID = SP.SoftwareID
                    INNER JOIN Platform P ON P.PlatformID = SP.PlatformID
                    INNER JOIN Status SS ON SS.StatusID = S.StatusID
                    WHERE SP.PlatformID = '$PlatformID'");
        //dd($data);
        return view('my_projects.platform_wise', compact('PlatformID', 'data'));
    }

    public function edit($id)
    {
        //dd($id);
        $project = Project::find($id);

        //dd($project);
        $status = Status::all();
        $platform = Platform::all();
        $developers = Developer::all();
        $departments = Department::all();
        $time_frame = TimeFrame::where('Active', 'Y')->get();

        $user_platform = SoftwarePlatform::where('SoftwareID', $project->SoftwareID)->get();
        $user_developers = SoftwareDeveloper::where('SoftwareID', $project->SoftwareID)->get();
        $user_departments = SoftwareDepartment::where('SoftwareID', $project->SoftwareID)->get();

        return view('my_projects.edit', compact('project', 'status', 'platform', 'developers', 'departments', 'time_frame', 'user_platform', 'user_developers', 'user_departments'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $project = Project::find($id);
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
        $project->StatusID = $request->StatusID;
        $project->Value = isset($request->Value) ? $request->Value : 0;
        $project->TimeFrameID = isset($request->TimeFrameID) ? $request->TimeFrameID : 0;
        $project->EntryBy = Auth::user()->UserID;
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
        return redirect()->route('my_project.index');
    }

    public function destroy(Project $project)
    {
        dd($$project);
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

    public function my_project_export()
    {
        //$temp = Excel::download(new ProjectsExport, 'project_export.xlsx');
        //dd($temp);
        return \Maatwebsite\Excel\Facades\Excel::download(new MyProjectsExport, 'my_projects_export.xlsx');
        //return $temp;
    }
}
