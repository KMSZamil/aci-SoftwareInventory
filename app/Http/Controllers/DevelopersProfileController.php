<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\SoftwareDeveloper;
use App\Models\UserManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DevelopersProfileController extends Controller
{
    public function index()
    {
        //$developers = Developer::with('user_info')->orderBy('DeveloperID')->get();
        $developers = DB::select("exec sp_DeveloperWiseCount");
        //dd($developers);
        return view('developers_profile.index', compact('developers'));
    }

    public function developers_details(Request $request, $id)
    {
        //dd($id);
        // $UserID = $id;
        // $UserID = isset($UserID) && $UserID == 123456 ? '%' : $UserID;
        // $data = SoftwareDeveloper::where('DeveloperID', 'like', '%' . $UserID . '%')->with('projects.platforms.platform_name', 'projects.departments.department_name', 'projects.developers.developer_name')->get();
        // dd($data);
        if ($request->ajax()) {
            $UserID = $id;
            $UserID = isset($UserID) && $UserID == 123456 ? '%' : $UserID;
            $data = SoftwareDeveloper::where('DeveloperID', 'like', '%' . $UserID . '%')->with('projects.platforms.platform_name', 'projects.departments.department_name', 'projects.developers.developer_name')->get();
            return DataTables::of($data)
                ->addColumn('Status', function ($row) {
                    if ($row->projects->StatusID == 4) {
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
                    return isset($row->projects->Description) ? $row->projects->Description : '';
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
        $UserID = $id;
        $user_data = UserManager::where('UserID', $UserID)->first();
        return view('developers_profile.details', compact('user_data'));
    }
}
