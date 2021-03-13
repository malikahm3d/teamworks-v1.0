<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(Role::select('name')->where('name',request()->name)->exists());
        if(Role::select('name')->where('name',request()->name)->exists()){
            return redirect()->back()->with('error', 'Role with similar name already exists!');
        }
        else
        {
            $role = Role::create(['name' => request()->name]);
            if (!empty($request->get('perm'))) {
                $role->syncPermissions($request->get('perm'));
            }
            return redirect()->back()->with('message', 'Role created successfully');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('admin.role.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->get('name')]);
        if (!empty($request->get('perm'))) {
            $role->syncPermissions($request->get('perm'));
        }
        return redirect(route('roles.index'))->with('message', 'Role Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // dd($role->id);
        $role->delete();
        return redirect()->back()->with('message', 'Role Removed Successfully!');
    }

    public function manage()
    {
        $roles = Role::all();
        $users = User::all();
        // $saeed = User::findById(1);
        // $saeed->fresh();
        //$admin = Role::findById(1);
        //$saeed2->syncRoles([$admin]);
        // $malik->syncRoles([$role2]);
        //dd($users[0]->roles);
        return view('admin.role.manage', compact('roles', 'users'));
    }

    public function updateRoles(Request $request)
    {
        // dd($request->all());
        $user = User::findById($request->get('user'));
        $roles =[];
        if (! is_null($request->get('role'))) {
            foreach ($request->get('role') as $role) {
                array_push($roles, Role::findById($role));
            }
            // $roles = $request->get('role');
            //dd($roles);
            $user->syncRoles($roles);
        }

        return redirect(route('roles.index'))->with('message', 'Roles Assigned to User Successfully!');
    }

    // public function getUsers(Role $role)
    // {
    //     return $role->users->get();
    // }
    
}
