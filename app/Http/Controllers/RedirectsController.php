<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RedirectsController extends Controller
{
    public function index(Request $request)
    {
        if($request->user()->hasRole("staff"))
        {
            return redirect("/staff/dashboard");
        }

        if($request->user()->hasRole("parent"))
        {
            return redirect("/parent/dashboard");
        }

        if($request->user()->hasRole("admin"))
        {
            return redirect("/admin/dashboard");
        }
    }

    public function dummy()
    {
        $admin_role = Role::create(["name" => "admin"]);
        $parent_role = Role::create(["name" => "parent"]);
        $staff_role = Role::create(["name" => "staff"]);

        $models = [
            "child","meal","attendance",
            "parent","staff","admin",
        ];

        $verbs = [
            "browse","read",
            "edit","add","delete",
        ];

        foreach ($verbs as $verb) {
            foreach ($models as $model) {
                Permission::create(["name" => $verb . "-" . $model]);
                $admin_role->givePermissionTo($verb. "-" . $model);
            }
        }

        $parent_role->givePermissionTo("read-child");
        $parent_role->givePermissionTo("browse-child");
        $parent_role->givePermissionTo("edit-child");
        $parent_role->givePermissionTo("add-child");
        $parent_role->givePermissionTo("read-meal");
        $parent_role->givePermissionTo("browse-meal");
        $parent_role->givePermissionTo("read-attendance");
        $parent_role->givePermissionTo("browse-attendance");
        $parent_role->givePermissionTo("read-parent");
        $parent_role->givePermissionTo("edit-parent");
        $parent_role->givePermissionTo("delete-parent");

        $staff_role->givePermissionTo("read-child");
        $staff_role->givePermissionTo("add-child");
        $staff_role->givePermissionTo("edit-child");
        $staff_role->givePermissionTo("browse-child");
        $staff_role->givePermissionTo("browse-meal");
        $staff_role->givePermissionTo("read-meal");
        $staff_role->givePermissionTo("browse-parent");
        $staff_role->givePermissionTo("read-parent");
        $staff_role->givePermissionTo("edit-parent");
        $staff_role->givePermissionTo("add-parent");
        $staff_role->givePermissionTo("browse-staff");
        $staff_role->givePermissionTo("read-staff");
        $staff_role->givePermissionTo("edit-staff");
        $staff_role->givePermissionTo("browse-attendance");
        $staff_role->givePermissionTo("read-attendance");
        $staff_role->givePermissionTo("edit-attendance");
        $staff_role->givePermissionTo("add-attendance");

        return "Success!";
    }
}
