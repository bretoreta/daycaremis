<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Attendance;
use App\Models\Child;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $childrenIds = $request->user()->children()->pluck('id')->toArray();

        return Inertia::render("Parent/Dashboard", [
            'attendances' => Attendance::where('child_id', $childrenIds)->latest()->take(5)->get(),
            "count" => [
                "admins" => User::role("admin")->count(),
                "staff" => User::role("staff")->count(),
                "parents" => User::role("parent")->count(),
                "children" => Child::all()->count(),
                "meals" => Meal::all()->count(),
                ]
            ]);
    }

    public function profile(Request $request)
    {
        return Inertia::render('Admin/Profile', [
            'sessions' => $this->sessions($request)->all(),
        ]);
    }

    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->user()->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
