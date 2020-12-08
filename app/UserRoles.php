<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'user_roles';
    public $timestamps = false;

    public function scopeUser($query, $user) {
        return $query->where('user_id', $user);
    }

    public function scopeRole($query, $role) {
        return $query->where('roles_id', $role);
    }

    public function scopeTourn($query, $tourn) {
        return $query->where('tourn_id', $tourn);
    }
}
