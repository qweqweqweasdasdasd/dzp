<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cj extends Model
{
    protected $table = 'cj';
    protected $primaryKey = 'id';
    protected $fillable = ['count','mem_id','created_at','activity_type','order','deleted_at'];

 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
