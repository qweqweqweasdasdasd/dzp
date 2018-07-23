<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    protected $table = 'member';
    protected $primaryKey = 'id';
    protected $fillable = ['mem_no','mem_name','mem_pwd','mem_mobile','mg_id','order','created_at','deleted_at','activity_type','remember_token'];

 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];

}
