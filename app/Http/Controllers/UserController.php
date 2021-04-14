<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct() {
        $this->middleware('role:admin')->only('create');
        $this->middleware(['role:admin|moderator'])->only('adminPanel');
        $this->middleware('can:update,user')->only(['edit', 'update']);
        $this->middleware('can:delete,user')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard');
    }

    public function adminPanel()
    {
        $user = auth()->user();
        if($user->hasAnyRole(['admin', 'moderator']))
            return view('admin.home', compact('user'));
    }

    public function univeristiesOrganizations()
    {
        return view('admin.organization.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // $moderator_role = Role::findByName('moderator');
        // $user->syncRoles([$moderator_role]);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update(['name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,]);
        //TODO data validation
        //dd($request->all());
        return redirect(route('dashboard'))->with('message', 'User Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $user->comments()->each(function($comment) {
            $comment->delete(); // <-- direct deletion
         });
         $user->posts()->each(function($post) {
            if(!is_null($post->file)) $post->file->delete();
            $post->delete(); // <-- direct deletion
         });
        $user->delete();

        return redirect(route('login'))->with('message', 'User Deleted Successfully!');
    }

    public function getRoles(User $user)
    {
        return $user->roles;
    }

    public function getPermissions(User $user)
    {
        return $user->getAllPermissions();
    }
}
