<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('browse-child'))
        {
            if($request->user()->hasRole('parent'))
            {
                return Inertia::render("Children/Index", [
                    "children" => $request->user()->children()->with(['parent','meal'])->get(),
                    "parents" => User::role('parent')->get(),
                    'meals' => Meal::all(),
                    'can' => [
                        'browse' => $request->user()->roles()->first()->hasPermissionTo('browse-child'),
                        'read' => $request->user()->roles()->first()->hasPermissionTo('read-child'),
                        'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-child'),
                        'add' => $request->user()->roles()->first()->hasPermissionTo('add-child'),
                        'delete' => $request->user()->roles()->first()->hasPermissionTo('delete-child'),
                    ]
                ]);
            }
            else
            {
                return Inertia::render("Children/Index", [
                    "children" => Child::with(['parent', 'meal'])->get(),
                    "parents" => User::role('parent')->get(),
                    'meals' => Meal::all(),
                    'can' => [
                        'browse' => $request->user()->roles()->first()->hasPermissionTo('browse-child'),
                        'read' => $request->user()->roles()->first()->hasPermissionTo('read-child'),
                        'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-child'),
                        'add' => $request->user()->roles()->first()->hasPermissionTo('add-child'),
                        'delete' => $request->user()->roles()->first()->hasPermissionTo('delete-child'),
                    ]
                ]);
            }
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
        if($request->user()->roles()->first()->hasPermissionTo('add-child'))
        {
            $request->validate([
                "first_name" => "required|string|max:255",
                "middle_name" => "string|max:255",
                "last_name" => "required|string|max:255",
                "dob" => "required|string|max:255",
                "gender" => "required|string|max:12",
                "user_id" => "required|exists:users,id",
                "meal_id" => "required|exists:meals,id",
            ]);
    
            Child::create([
                "first_name" => $request["first_name"],
                "middle_name" => $request["middle_name"],
                "last_name" => $request["last_name"],
                "dob" => $request["dob"],
                "gender" => $request["gender"],
                "user_id" => $request["user_id"],
                "meal_id" => $request["meal_id"],
            ]);
    
            return redirect()->back()->with("message","Child created successfully");
        }

        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Child  $child
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Child $child)
    {
        if($request->user()->roles()->first()->hasPermissionTo('read-child'))
        {
            return Inertia::render("Children/Show", [
                "child" => Child::where('id', $child->id)->with(['meal', 'parent'])->first(),
                'parents' => User::role('parent')->get(),
                'meals' => Meal::all(),
                'can' => [
                    'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-child'),
                ]
            ]);
        }

        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Child  $child
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Child $child)
    {
        if($request->user()->roles()->first()->hasPermissionTo('read-child'))
        {
            $request->validate([
                "first_name" => "required|string|max:255",
                "middle_name" => "string|max:255",
                "last_name" => "required|string|max:255",
                "dob" => "required|string|max:255",
                "gender" => "required|string|max:12",
                "user_id" => "required",
            ]);
    
            $child->update($request->all());
    
            return redirect()->back()->with("message", "Child updated successfully");
        }

        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Child  $child
     * @return \Illuminate\Http\Response
     */
    public function destroy(Child $child)
    {
        $child->delete();

        return redirect()->back()->with("message", "Child deleted successfully");
    }
}
