<?php

namespace App\Http\Controllers\Report;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function department_wise_report(Request $request)
    {   
        if($request->has('SoftwareDepartment')) {
            $projects = Project::with([
                'platforms.platform_name', 
                'departments' => function($query) use($request){
                    return $query->whereIn('DepartmentCode',$request->SoftwareDepartment);
                },
                'developers.developer_name',
                'departments.department_name'
            ])
            ->whereHas('departments',function($query) use ($request){
               return $query->whereIn('DepartmentCode',$request->SoftwareDepartment);
            })
            ->get();

            return view('report.department_wise_report',[
                'projects' => $projects,
                'department' => $request->SoftwareDepartment
            ]);
        }
        

        return view('report.department_wise_report');
    }
}
