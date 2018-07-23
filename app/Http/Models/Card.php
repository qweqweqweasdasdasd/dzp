<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    protected $table = 'card';
    protected $primaryKey = 'card_id';
    protected $fillable = ['desc','sudoku_id','created_at','deleted_at'];

 	use SoftDeletes;
    protected $dates 	  = ['deleted_at'];
}
