<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\GenController;

use App\Models\Permission;

class BaseController extends GenController
{
    const RETSUCCESS = "yes";
    const CREATESUCCESS = "添加成功";
    const EDITSUCCESS = "修改成功";
    const DELSUCCESS = "删除成功";


    const RETFAIL = "no";
    const SONSOVERONE = "该菜单下仍存在子菜单不允许删除";
    const EDITROLEMAX = "最高权限角色不允许修改或删除";
    const EMAIL_EXIST = "该用户邮箱已存在";

    protected $page = 20;   //分页信息

    //获取菜单的父级菜单名称
    /**
     * @param  array/object  $menus
     *
     * @return array/object $menus
     */
    protected function getParentsName($menus)
    {
        foreach($menus as $key=>$menu)
        {
            if($menu['parent_id'] == Permission::PARENT_MENU) {
                $menus[$key]['parent_name'] = '一级菜单';
            } else {
                $menus[$key]['parent_name'] = Permission::whereId($menu['parent_id'])->pluck('display_name');
            }
        }

        return $menus;
    }

    //修改排序
    /**
     * @param  object  $obj 一个含有display_order的对象
     * @param  array   $params 含有传输值得数组
     *
     * @return array   返回一个需要返回的$result
     */
    protected function editDisplayOrder($obj, $params)
    {
        $obj->display_order = $params['display_order'];
        $obj->save();

        return array('ret'=>self::RETSUCCESS, 'msg'=>self::EDITSUCCESS,'display_order'=>$obj->display_order);
    }

    //获取所有一级菜单
    /**
     *
     * @return object $parent_menu 将会返回一个包含所有一级菜单的对象
     */
    protected function getAllParentMenus()
    {
        $parent_menu = Permission::whereParentId(Permission::PARENT_MENU)->whereIsMenu(Permission::IS_MENU)->orderBy('display_order', 'asc')->get();
        return $parent_menu;
    }

    //获取一个加密后的密码
    /**
     * @param  string  $password 一个原始密码
     *
     * @return string  $newpassword 一个经过加密后的密码
     */
    protected function getNewPassWord($password)
    {
        $newpassword = bcrypt($password);
        return $newpassword;
    }

    //判断输入用户是否包含输入权限
    /**
     * @param  object  $permission 所有权限
     * @param  object  $user       当前登录用户
     *
     * @return boolean bool        如果拥有权限返回true，无权限返回false
     */
    protected function hasPermission($permission, $user)
    {
        foreach($permission->roles as $role)
        {
            if($role->id == $user->role->id) {
                return true;
            }
        }
        return false;
    }
}
