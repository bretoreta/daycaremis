<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('browse-parent'))
        {
            return Inertia::render("Parent/_Parents/Index", [
                "parents" => User::role("parent")->get(),
                'can' => [
                    'browse' => $request->user()->roles()->first()->hasPermissionTo('browse-parent'),
                    'read' => $request->user()->roles()->first()->hasPermissionTo('read-parent'),
                    'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-parent'),
                    'add' => $request->user()->roles()->first()->hasPermissionTo('add-parent'),
                    'delete' => $request->user()->roles()->first()->hasPermissionTo('delete-parent'),
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

        // TOD0 : ADD LOGIC GATE TO VERIFY UPDATE
        // Check if user is admin first then Gate
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "gender" => "required|string|max:12",
            "address" => "required|string|max:255",
            "password" => "required|confirmed|max:255",
            'relation_to_child' => 'required|string|max:20',
        ]);

        $user = User::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "gender" => $request["gender"],
            "address" => $request["address"],
            'relation_to_child' => $request['relation_to_child'],
            "password" => Hash::make($request["password"]),
        ]);
        $user->assignRole("parent");

        return redirect()->back()->with("message","Parent created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        if($request->user()->roles()->first()->hasPermissionTo('read-parent'))
        {
            if($user->hasRole('parent'))
            {
                return Inertia::render("Parent/_Parents/Show", [
                    "parent" => $user,
                    'parents' => User::role('parent')->get(),
                    'children' => $user->load(['children.meal', 'children.attendances' => function ($query) {
                                        $query->latest();
                                    }])->get(), 
                    'meals' => Meal::all(),
                    'can' => [
                        'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-parent'),
                        'child' => [
                            'add' => $request->user()->roles()->first()->hasPermissionTo('add-child'),
                            'read' => $request->user()->roles()->first()->hasPermissionTo('read-child'),
                            'delete' => $request->user()->roles()->first()->hasPermissionTo('delete-child'),
                        ]
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
    public function update(Request $request, User $user)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255",
            "gender" => "required|string|max:12",
            "address" => "required|string|max:255",
            'relation_to_child' => 'required|string|max:20',
        ]);

        $user->update($request->all());

        return redirect()->back()->with("message", "Parent updated successfully");
    }

    public function destroy(Request $request, User $user)
    {
        // TOD0 : ADD LOGIC GATE TO VERIFY DELETE
        // Check if user is admin first then Gate
        if($request->user()->roles()->first()->hasPermissionTo('delete-parent'))
        {
            $user->removeRole("parent");
            $user->delete();

            return redirect()->back()->with("message", "User account deleted successfully");
        }

        abort(403);
    }
}
