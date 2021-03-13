<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.permission.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Permission::select('name')->where('name',request()->name)->exists()){
            return redirect()->back()->with('error', 'Permission with similar name already exists!');
        }
        else
        {
            $permission = Permission::create(['name' => request()->name]);
            if (!empty($request->get('role'))) {
                $permission->syncRoles($request->get('role'));
            }
            return redirect()->back()->with('message', 'Permission created successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.permission.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        return view('admin.permission.edit', compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->update(['name' => $request->get('name')]);
        if (!empty($request->get('role'))) {
            $permission->syncRoles($request->get('role'));
        }
        return redirect(route('permissions.index'))->with('message', 'Permission Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('message', 'Permission Removed Successfully!');
    }

    public function manage()
    {
        $permissions = Permission::all();
        $users = User::all();
        // $saeed = User::findById(1);
        // $saeed->fresh();
        //$admin = Role::findById(1);
        //$saeed2->syncRoles([$admin]);
        // $malik->syncRoles([$role2]);
        //dd(User::role('admin')->get());
        // dd($users[2]->getDirectPermissions());
        return view('admin.permission.manage', compact('permissions', 'users'));
    }

    public function updatePermissions(Request $request)
    {
        // dd($request->all());
        $user = User::findById($request->get('user'));
        $permissions =[];
        if (! is_null($request->get('permission'))) {
            foreach ($request->get('permission') as $permission) {
                array_push($permissions, Permission::findById($permission));
            }
            // $roles = $request->get('role');
            //dd($roles);
        }
        $user->syncPermissions($permissions);

        return redirect(route('permissions.index'))->with('message', 'User Permissions Updated Successfully!');
    }

    // public function getUsers(Permission $permission)
    // {
        
    //     return $permission->users->get();
    // }
}
