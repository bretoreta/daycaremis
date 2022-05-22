<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\User;
use App\Notifications\AdminAdded;
use App\Notifications\AdminModified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Notification;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render("Admin/_Admins/Index", [
            "admins" => User::role("admin")->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "gender" => "required|string|max:12",
            "address" => "required|string|max:255",
            "password" => "required|confirmed|max:255",
        ]);

        $admin = User::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "gender" => $request["gender"],
            "address" => $request["address"],
            "password" => Hash::make($request["password"]),
        ]);
        $admin->assignRole("admin");

        $ids = User::role('admin')->get();
        $admins = $ids->whereNotIn('id', auth()->id());

        Notification::send($admins, new AdminAdded($admin));
        Action::create([
            'responsible_role' => $request->user()->roles()->first()->name,
            'responsible_user' => $request->user(),
            'action_done' => ' created an Admin',
            'affected_record' => json_encode($admin),
        ]);

        return redirect()->back()->with("message","Administrator created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user->hasRole('admin'))
        {
            return Inertia::render("Admin/_Admins/Show", [
                "admin" => $user
            ]);
        }

        abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "gender" => "required|string|max:12",
            "address" => "required|string|max:255",
        ]);

        $user->update($request->all());

        $ids = User::role('admin')->get();
        $admins = $ids->whereNotIn('id', auth()->id());
        
        Notification::send($admins, new AdminModified($user));
        Action::create([
            'responsible_role' => $request->user()->roles()->first()->name,
            'responsible_user' => $request->user(),
            'action_done' => ' updated an Admin',
            'affected_record' => json_encode($user),
        ]);

        return redirect()->back()->with("message", "Administrator updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Request $request)
    {
        $user->removeRole("admin");
        $user->delete();

        Action::create([
            'responsible_role' => $request->user()->roles()->first()->name,
            'responsible_user' => $request->user(),
            'action_done' => ' updated an Admin',
            'affected_record' => json_encode($user),
        ]);

        return redirect()->back()->with("message", "Admin account deleted successfully");
    }
}
