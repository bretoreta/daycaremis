<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Child;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('browse-attendance'))
        {
            if($request->user()->hasRole('parent'))
            {
                $childrenIds = $request->user()->children()->pluck('id')->toArray();
            
                return Inertia::render("Attendances/Index", [
                    "attendances" => Attendance::where('child_id', $childrenIds)->latest()->get(),
                    'staff' => User::role('staff')->get(),
                    'children' => Child::all(),
                    'can' => [
                        'browse' => $request->user()->roles()->first()->hasPermissionTo('browse-attendance'),
                        'read' => $request->user()->roles()->first()->hasPermissionTo('read-attendance'),
                        'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-attendance'),
                        'add' => $request->user()->roles()->first()->hasPermissionTo('add-attendance'),
                        'delete' => $request->user()->roles()->first()->hasPermissionTo('delete-attendance'),
                    ]
                ]);
            }
            else
            {
                return Inertia::render("Attendances/Index", [
                    "attendances" => Attendance::all(),
                    'staff' => User::role('staff')->get(),
                    'children' => Child::all(),
                    'can' => [
                        'browse' => $request->user()->roles()->first()->hasPermissionTo('browse-attendance'),
                        'read' => $request->user()->roles()->first()->hasPermissionTo('read-attendance'),
                        'edit' => $request->user()->roles()->first()->hasPermissionTo('edit-attendance'),
                        'add' => $request->user()->roles()->first()->hasPermissionTo('add-attendance'),
                        'delete' => $request->user()->roles()->first()->hasPermissionTo('delete-attendance'),
                    ]
                ]);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('add-attendance'))
        {
            $request->validate([
                'caretaker_id' => 'required|exists:users,id',
                'child_id' => 'required|exists:children,id',
                'drop_off' => 'required|max:255',
                'pick_up' => 'max:255',
            ]);
    
            $cared_for_ids = Attendance::where('pick_up', null)->pluck('child_id')->toArray();
    
            if(in_array($request['child_id'], $cared_for_ids)) {
                return redirect()->back()->with('message', 'The selected Child is already in Care');
            }
    
            Attendance::create($request->all());
    
            return redirect()->back()->with("message","Attendance created successfully");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Attendance  $attendance
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance, Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('read-attendance'))
        {
            return Inertia::render("Attendances/Show", [
                "attendance" => $attendance,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        if($request->user()->roles()->first()->hasPermissionTo('edit-attendance'))
        {
            $request->validate([
                'pick_up' => 'required|max:255',
            ]);
    
            $attendance->update([
                'pick_up' => $request['pick_up']
            ]);
    
            return redirect()->back()->with("message", "Attendance updated successfully");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Attendance  $attendance
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance, Request $request)
    {
        if($request->user()->roles()->first()->hasPermissionTo('delete-attendance'))
        {
            $attendance->delete();

            return redirect()->back()->with("message", "Attendance deleted successfully");
        }
    }
}
