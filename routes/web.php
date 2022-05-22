<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\Parent\HomeController as ParentHomeController;
use App\Http\Controllers\Staff\HomeController as StaffHomeController;
use App\Http\Controllers\RedirectsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route for redirecting users according to their role
Route::get("/redirect", [RedirectsController::class, "index"]);
Route::post("/complaints", [ComplaintsController::class, "store"]);
Route::post("/feedback", [FeedbackController::class, "store"]);

// Route for Reading Notifications
Route::post("/read/notification/{notification}", [NotificationsController::class, "read"])->name("notif.read");

// Administrator Routes
Route::group(["middleware" => ["auth", "role:admin"]], function() {
    // The Administrators' Base Routes
        // The Administrator's Dashboard
        Route::get("/admin/dashboard", [HomeController::class, "dashboard"])->name("admin.dashboard");

        // The Administrator's Profile
        Route::get("/admin/profile", [HomeController::class, "profile"])->name("admin.profile");

    // Routes for managing users who are Admins
    Route::get("/admin/admins", [AdminsController::class, "index"])->name("admin.admins.index");
    Route::get("/admin/admins/{user}", [AdminsController::class, "show"])->name("admin.admins.show");
    Route::post("/admin/admins", [AdminsController::class, "store"])->name("admin.admins.store");
    Route::patch("/admin/admins/{user}", [AdminsController::class, "update"])->name("admin.admins.update");
    Route::delete("/admin/delete/{user}", [AdminsController::class, "destroy"])->name("admin.admins.destroy");

    // Routes for managing users who are Staff
    Route::get("/admin/staff", [StaffController::class, "index"])->name("admin.staff.index");
    Route::get("/admin/staff/{user}", [StaffController::class, "show"])->name("admin.staff.show");
    Route::post("/admin/staff", [StaffController::class, "store"])->name("admin.staff.store");
    Route::patch("/admin/staff/{user}", [StaffController::class, "update"])->name("admin.staff.update");
    Route::delete("/staff/delete/{user}", [StaffController::class, "destroy"])->name("admin.staff.destroy");

    // Routes for managing users who are Parents
    Route::get("/admin/parents", [ParentsController::class, "index"])->name("admin.parents.index");
    Route::get("/admin/parents/{user}", [ParentsController::class, "show"])->name("admin.parents.show");
    Route::post("/admin/parents", [ParentsController::class, "store"])->name("admin.parents.store");
    Route::patch("/admin/parents/{user}", [ParentsController::class, "update"])->name("admin.parents.update");
    Route::delete("/parent/delete/{user}", [ParentsController::class, "destroy"])->name("admin.parents.destroy");

    // Routes for managing children
    Route::get("/admin/children", [ChildrenController::class, "index"])->name("admin.children.index");
    Route::get("/admin/children/{child}", [ChildrenController::class, "show"])->name("admin.children.show");
    Route::post("/admin/children", [ChildrenController::class, "store"])->name("admin.children.store");
    Route::patch("/admin/children/{child}", [ChildrenController::class, "update"])->name("admin.children.update");
    Route::delete("/child/delete/{child}", [ChildrenController::class, "destroy"])->name("admin.children.destroy");

    // Routes for managing meals
    Route::get("/admin/meals", [MealsController::class, "index"])->name("admin.meals.index");
    Route::get("/admin/meals/{meal}", [MealsController::class, "show"])->name("admin.meals.show");
    Route::post("/admin/meals", [MealsController::class, "store"])->name("admin.meals.store");
    Route::patch("/admin/meals/{meal}", [MealsController::class, "update"])->name("admin.meals.update");
    Route::delete("/meal/delete/{meal}", [MealsController::class, "destroy"])->name("admin.meals.destroy");

    // Routes for managing attendances
    Route::get("/admin/attendances", [AttendancesController::class, "index"])->name("admin.attendances.index");
    Route::get("/admin/attendances/{attendance}", [AttendancesController::class, "show"])->name("admin.attendances.show");
    Route::post("/admin/attendances", [AttendancesController::class, "store"])->name("admin.attendances.store");
    Route::patch("/admin/attendances/{attendance}", [AttendancesController::class, "update"])->name("admin.attendances.update");
    Route::delete("/attendance/delete/{attendance}", [AttendancesController::class, "destroy"])->name("admin.attendances.destroy");

    // Route for Complaints and Feedback
    Route::get("/complaints/register", [ComplaintsController::class, "show"])->name("complaints.show");
    Route::get("/feedback/register", [FeedbackController::class, "show"])->name("feedback.show");
});

// Staff Routes
Route::group(["middleware" => ["auth", "role:staff"]], function() {
    // The Staff's Base Routes
        // The Staff's Dashboard
        Route::get("/staff/dashboard", [StaffHomeController::class, "dashboard"])->name("staff.dashboard");

        // The Staff's Profile
        Route::get("/staff/profile", [StaffHomeController::class, "profile"])->name("staff.profile");

    // Routes for managing users who are Staff
    Route::get("/staff/staff", [StaffController::class, "index"])->name("staff.staff.index");
    Route::get("/staff/staff/{user}", [StaffController::class, "show"])->name("staff.staff.show");
    Route::patch("/staff/staff/{user}", [StaffController::class, "update"])->name("staff.staff.update");

    // Routes for managing users who are Parents
    Route::get("/staff/parents", [ParentsController::class, "index"])->name("staff.parents.index");
    Route::get("/staff/parents/{user}", [ParentsController::class, "show"])->name("staff.parents.show");
    Route::post("/staff/parents", [ParentsController::class, "store"])->name("staff.parents.store");
    Route::patch("/staff/parents/{user}", [ParentsController::class, "update"])->name("staff.parents.update");

    // Routes for managing children
    Route::get("/staff/children", [ChildrenController::class, "index"])->name("staff.children.index");
    Route::get("/staff/children/{child}", [ChildrenController::class, "show"])->name("staff.children.show");
    Route::post("/staff/children", [ChildrenController::class, "store"])->name("staff.children.store");
    Route::patch("/staff/children/{child}", [ChildrenController::class, "update"])->name("staff.children.update");
    Route::delete("/child/delete/{child}", [ChildrenController::class, "destroy"])->name("staff.children.destroy");

    // Routes for managing meals
    Route::get("/staff/meals", [MealsController::class, "index"])->name("staff.meals.index");
    Route::get("/staff/meals/{meal}", [MealsController::class, "show"])->name("staff.meals.show");

    // Routes for managing attendances
    Route::get("/staff/attendances", [AttendancesController::class, "index"])->name("staff.attendances.index");
    Route::get("/staff/attendances/{attendance}", [AttendancesController::class, "show"])->name("staff.attendances.show");
    Route::post("/staff/attendances", [AttendancesController::class, "store"])->name("staff.attendances.store");
    Route::patch("/staff/attendances/{attendance}", [AttendancesController::class, "update"])->name("staff.attendances.update");

    // Route for Complaints and Feedback
    Route::get("/complaints/register", [ComplaintsController::class, "show"])->name("complaints.show");
    Route::get("/feedback/register", [FeedbackController::class, "show"])->name("feedback.show");
});

// Parent Routes
Route::group(["middleware" => ["auth", "role:parent"]], function() {
    // The Parents' Base Routes
        // The Parent's Dashboard
        Route::get("/parent/dashboard", [ParentHomeController::class, "dashboard"])->name("parent.dashboard");

        // The Parent's Profile
        Route::get("/parent/profile", [ParentHomeController::class, "profile"])->name("parent.profile");

        // Routes for managing children
        Route::get("/parent/children", [ChildrenController::class, "index"])->name("parent.children.index");
        Route::get("/parent/children/{child}", [ChildrenController::class, "show"])->name("parent.children.show");
        Route::patch("/parent/children/{child}", [ChildrenController::class, "update"])->name("parent.children.update");

        // Routes for managing meals
        Route::get("/parent/meals", [MealsController::class, "index"])->name("parent.meals.index");
        Route::get("/parent/meals/{meal}", [MealsController::class, "show"])->name("parent.meals.show");

        // Routes for managing attendances
        Route::get("/parent/attendances", [AttendancesController::class, "index"])->name("parent.attendances.index");
        Route::get("/parent/attendances/{attendance}", [AttendancesController::class, "show"])->name("parent.attendances.show");

        // Route for Complaints and Feedback
        Route::get("/complaints/register", [ComplaintsController::class, "show"])->name("complaints.show");
        Route::get("/feedback/register", [FeedbackController::class, "show"])->name("feedback.show");
});