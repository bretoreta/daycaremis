<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComplaintsController extends Controller
{
    public function show(Request $request)
    {
        return Inertia::render('Complaints/Register',[
            'complaints' => $request->user()->complaints()->latest()->take(3)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'brief_title' => 'string|max:20|required',
            'detailed_info' => 'string|max:400|required',
        ]);

        $tracking_token = md5($request->user()->name . now());
        Complaint::create([
            'tracking_no' => $tracking_token,
            'user_id' => $request->user()->id,
            'brief_title' => $request->brief_title,
            'detailed_info' => $request->detailed_info,
        ]);

        return redirect()->back()->with('message', 'Complaint Registered Successfully');
    }
}
