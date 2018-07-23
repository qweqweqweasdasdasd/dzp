<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jika extends Model
{
    protected $table = 'jika';
    protected $primaryKey = 'jika_id';
    protected $fillable = ['user','phone','huodong_desc','desc','created_at','deleted_at'];

 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
