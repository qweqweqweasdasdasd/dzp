<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    protected $table = 'activity';
    protected $primaryKey = 'id';
    protected $fillable = ['name','desc','created_at'];

 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
