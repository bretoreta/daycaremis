<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Meal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('browse-meal'))
        {
            return Inertia::render("Meals/Index", [
                "children" => Child::has('meal')->get(),
                'meals' => Meal::all(),
                'can' => [
                    'browse' => $request->user()->roles()->first()->hasPermissionTo('browse-meal'),
                    'read' => $request->user()->roles()->first()->hasPermissionTo('read-meal'),
                    'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-meal'),
                    'add' => $request->user()->roles()->first()->hasPermissionTo('add-meal'),
                    'delete' => $request->user()->roles()->first()->hasPermissionTo('delete-meal'),
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
        $request->validate([
            'name' => 'required|string|max:255',
            'breakfast' => 'required|string|max:255',
            'lunch' => 'required|string|max:255',
            'supper' =>'required|string|max:255',
            'special?' => 'string|max:255',
        ]);

        Meal::create($request->all());

        return redirect()->back()->with("message","Meal created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Meal $meal)
    {
        if($request->user()->roles()->first()->hasPermissionTo('read-meal'))
        {
            return Inertia::render("Meals/Show", [
                "meal" => Meal::where('id', $meal->id)->with('children')->first(),
                'can' => [
                    'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-meal'),
                ]
            ]);
        }

        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breakfast' => 'required|string|max:255',
            'lunch' => 'required|string|max:255',
            'supper' =>'required|string|max:255',
            'special?' => 'string|max:255',
        ]);

        $meal->update($request->all());

        return redirect()->back()->with("message", "Meal updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        $meal->delete();

        return redirect()->back()->with("message", "Meal deleted successfully");
    }
}
