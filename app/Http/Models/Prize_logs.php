<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prize_logs extends Model
{
    protected $table = 'prize_logs';
    protected $primaryKey = 'logs_id';
    protected $fillable = ['mem_no','prize_id','status','updated_at','created_at','deleted_at'];

    use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
