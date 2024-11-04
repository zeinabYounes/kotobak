<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    //use HasFactory;
    public $guarded = [];
    public $timestamps = false;
    // public function users()
    // {
    //     return $this->hasMany('App\Models\User','role_id');
    // }


}
