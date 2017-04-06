<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\Auth\Guard as Auth;

class DashboardController extends BaseController
{
    public function __construct(Permission $permission, Auth $auth, Role $role)
    {
        $this->permission = $permission;
        $this->auth = $auth;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = $this->permission->whereIsMenu(Permission::IS_MENU)->whereParentId(Permission::PARENT_MENU)->orderBy('display_order', 'asc')->get();

        $maxRole = $this->role->max('level');

        foreach($menus as $key=>$permission)
        {
            $menus[$key]['son_menu'] = Permission::whereParentId($permission->id)->orderBy('display_order', 'asc')->get();
            foreach($menus[$key]['son_menu'] as $k=>$v){
                if(!$this->hasPermission($v, $this->auth->user()) && $this->auth->user()->role->level != $maxRole)
                {
                    unset($menus[$key]['son_menu'][$k]);
                }
            }
            if(count($menus[$key]['son_menu']) == 0)
            {
                unset($menus[$key]);
            }

        }

        return view("dash.index", compact("menus"));
    }

    public function dash()
    {
        return view("dash.dash");
    }
}
