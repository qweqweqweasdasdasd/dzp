<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    protected $table = 'manager';
    protected $primaryKey = 'manager_id';
    protected $fillable = ['username','password','role_id','salt','status','updated_at','created_at','deleted_at','ip'];

 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

    //建立一对一的关系
 	public function role()
 	{
 		return $this->hasOne('App\Http\Models\Role','role_id','role_id');
 	}

}
