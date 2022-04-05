<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\Sample;
use App\Models\UserManager;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:User Manager']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->Active == 'Y' ? '<span  class="badge badge-pill badge-success">Active</span>' : '<span  class="badge badge-pill badge-danger">In-Active</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                    //$buttons .= '<a href="'.route('usermanager.show', $row->id).'"> <button class="btn btn-warning btn-xs">Show</button> </a>';
                    $buttons .= '<a href="' . route('usermanager.edit', $row->UserID) . '"> <button class="btn btn-info btn-xs">Edit</button> </a>';
                    //$buttons .= '<button class="btn btn-danger btn-xs" onclick="deleteConfirmation('.$row->UserID.')">Delete</button>';
                    return $buttons;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('usermanager.index');
    }

    public function create()
    {
        $permissions = \Spatie\Permission\Models\Permission::all()
            ->where('active', '=', 'Y')
            ->pluck('name');
        return view('usermanager.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'UserID' => 'required|unique:UserManager,UserID',
            'UserName' => 'required',
            'Password' => 'required|min:4',
        ]);

        $data_insert = User::create([
            'UserID' => $request->UserID,
            'UserName' => $request->UserName,
            'Designation' => isset($request->Designation) ? $request->Designation : '',
            'Email' => isset($request->Email) ? $request->Email : '',
            'Password' => Hash::make($request->Password),
            'CreateBy' => Auth::user()->UserID,
            'Active' => isset($request->Active) ? $request->Active : 'N'
        ]);

        if ($data_insert == true) {
            if (isset($request->Menu)) {
                for ($i = 0; $i < count($request->Menu); $i++) {
                    $data_insert->givePermissionTo($request->Menu[$i]);
                }
            }

            Toastr::success('User creation successful', 'GoodJob!', ["positionClass" => "toast-top-right"]);
        } else {
            Toastr::error('User creation Failed', 'Opps!', ["positionClass" => "toast-top-right"]);
        }

        return redirect()->route('usermanager.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserManager  $usermanager
     * @return \Illuminate\Http\Response
     */
    public function show(UserManager $usermanager)
    {
        return view('usermanager.index.show', compact('usermanager'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserManager  $usermanager
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(UserManager $usermanager)
    {
        $permissions = \Spatie\Permission\Models\Permission::all()
            ->where('active', '=', 'Y')
            ->pluck('name');
        $user_permission = User::with('permissions')->where('UserID', $usermanager->UserID)->first();

        return view('usermanager.edit', compact('usermanager', 'permissions', 'user_permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserManager  $usermanager
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UserManager $usermanager)
    {
        $request->validate([
            'UserName' => 'required',
            //'Email' => 'required|email',
        ]);

        if ($request->Password != null) {
            $usermanager = User::where('UserID', '=', $usermanager->UserID)->first();
            $usermanager->UserName = $request->UserName;
            $usermanager->Designation = isset($request->Designation) ? $request->Designation : '';
            $usermanager->Email = isset($request->Email) ? $request->Email : '';
            $usermanager->Password = Hash::make($request->Password);
            $usermanager->UpdateBy = Auth::user()->UserID;
            $usermanager->Active = (isset($request->Active) || $request->Active == 'Y') ? $request->Active : 'N';
        } else {
            $usermanager = User::where('UserID', '=', $usermanager->UserID)->first();
            $usermanager->UserName = $request->UserName;
            $usermanager->Designation = isset($request->Designation) ? $request->Designation : '';
            $usermanager->Email = isset($request->Email) ? $request->Email : '';
            $usermanager->UpdateBy = Auth::user()->UserID;
            $usermanager->Active = (isset($request->Active) || $request->Active == 'Y') ? $request->Active : 'N';
        }

        if ($usermanager->save() == true) {
            DB::table('UserHasPermissions')->where('UserID', $usermanager->UserID)->delete();
            if (isset($request->Menu)) {
                for ($i = 0; $i < count($request->Menu); $i++) {
                    $usermanager->givePermissionTo($request->Menu[$i]);
                }
            }
            Toastr::success('Data updated successfully', 'GoodJob!', ["positionClass" => "toast-top-right"]);
        } else {
            Toastr::error('Data not updated', 'Opps!', ["positionClass" => "toast-top-right"]);
        }
        return redirect()->route('usermanager.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserManager  $usermanager
     * @return array
     */

    public function destroy(UserManager $usermanager)
    {
        if ($usermanager->delete()) {
            DB::table('UserHasPermissions')->where('UserID', $usermanager->UserID)->delete();
            $data = array(
                'success' => true,
                'message' => 'User deleted successfully.'
            );
        } else {
            $data = array(

                'success' => false,
                'message' => 'User delete unsuccessful.'
            );
        }
        return $data;
    }
}
