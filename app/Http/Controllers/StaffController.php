<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\User;
use App\Notifications\StaffAdded;
use App\Notifications\StaffModified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('browse-staff'))
        {
            return Inertia::render("Staff/_Staff/Index", [
                "staff" => User::role("staff")->get(),
                'can' => [
                    'browse' => $request->user()->roles()->first()->hasPermissionTo('browse-staff'),
                    'read' => $request->user()->roles()->first()->hasPermissionTo('read-staff'),
                    'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-staff'),
                    'add' => $request->user()->roles()->first()->hasPermissionTo('add-staff'),
                    'delete' => $request->user()->roles()->first()->hasPermissionTo('delete-staff'),
                ]
            ]);
        }

        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('add-staff'))
        {
            $request->validate([
                "name" => "required|string|max:255",
                "email" => "required|email|max:255",
                "gender" => "required|string|max:12",
                "address" => "required|string|max:255",
                "password" => "required|confirmed|max:255",
            ]);
    
            $user = User::create([
                "name" => $request["name"],
                "email" => $request["email"],
                "gender" => $request["gender"],
                "address" => $request["address"],
                "password" => Hash::make($request["password"]),
            ]);
    
            $user->assignRole("staff");
            $admins = User::role('admin')->get();
            $staff = User::role('staff')->get();
    
            Notification::send($admins, new StaffAdded($user));
            Notification::send($staff, new StaffAdded($user));
            Action::create([
                'responsible_role' => $request->user()->roles()->first()->name,
                'responsible_user' => $request->user(),
                'action_done' => ' created a Staff',
                'affected_record' => json_encode($user)
            ]);
    
            return redirect()->back()->with("message","Staff created successfully");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('read-staff'))
        {
            if($user->hasRole('staff'))
            {
                return Inertia::render("Staff/_Staff/Show", [
                    "staff" => $user,
                    'can' => [
                        'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-staff'),
                    ]
                ]);
            }

            abort(400);
        }

        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        if($request->user()->roles()->first()->hasPermissionTo('edit-staff'))
        {
            $request->validate([
                "name" => "required|string|max:255",
                "email" => "required|email|max:255",
                "gender" => "required|string|max:12",
                "address" => "required|string|max:255",
            ]);
    
            $user->update($request->all());
            $admins = User::role('admin')->get();
            $staff = User::role('staff')->get();
    
            Notification::send($admins, new StaffModified($user));
            Notification::send($staff, new StaffModified($user));
            Action::create([
                'responsible_role' => $request->user()->roles()->first()->name,
                'responsible_user' => $request->user(),
                'action_done' => ' modified a Staff',
                'affected_record' => json_encode($user)
            ]);
    
            return redirect()->back()->with("message", "Staff updated successfully");
        }

        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if($request->user()->roles()->first()->hasPermissionTo('delete-staff'))
        {
            $user->removeRole("staff");
            $user->delete();

            return redirect()->back()->with("message", "User account deleted successfully");
        }

        abort(403);
    }
}
