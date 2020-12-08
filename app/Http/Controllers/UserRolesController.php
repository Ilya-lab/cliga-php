<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRoles;

class UserRolesController extends Controller
{
    /*
     * есть ли роль у пользователя
     */
    static function hasRole($user, $role) {
        $result = UserRoles::select('id')->user($user)->role($role)->get();
        foreach ($result as $res) {
            return true;
        }
        return false;
    }

    static function hasTournRole($user, $tourn, $role) {
        $result = UserRoles::select('id')->user($user)->role($role)->tourn($tourn)->get();
        foreach ($result as $res) {
            return true;
        }
        return false;
    }

    /**
     * Список ролей турнира
     * @param $user - идентификатор пользователя
     * @param $tourn - идентификтаор турнира
     * @return массив ролей
     */
    static function tournRole($user, $tourn) {
        return UserRoles::select('roles_id as role')->user($user)->tourn($tourn)->orderBy('roles_id')->get();
    }
}
