<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prize extends Model
{
    protected $table = 'prize';
    protected $primaryKey = 'prize_id';
    protected $fillable = ['p_name','p_img','p_rules','updated_at','created_at','deleted_at'];

    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
