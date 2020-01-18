<?php

namespace CrudProject\Classes;


class AccessControl
{
    public static function hasTopLevelMenuPermission()
    {
        $menuPermissions = array(
            'manage_options',
            'crud_project_full_access',
            'crud_project_can_view_menus'
        );
        foreach ($menuPermissions as $menuPermission) {
            if (current_user_can($menuPermission)) {
                return $menuPermission;
            }
        }
        return false;
    }
}
