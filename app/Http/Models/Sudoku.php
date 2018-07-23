<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Sudoku extends Model
{
    protected $table = 'sudoku';
    protected $primaryKey = 'id';
    protected $fillable = ['place','keyword','prize_id','deleted_at'];
}
