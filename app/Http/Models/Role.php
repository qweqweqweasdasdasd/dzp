<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
   	protected $table = 'role';
    protected $primaryKey = 'role_id';
    protected $fillable = ['role_name','ps_ids','ps_ca','updated_at','created_at','deleted_at'];

    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
