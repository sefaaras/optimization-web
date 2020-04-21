<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    public $timestamps = false;
    protected $table = 'algorithms';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'parameter', 'reference', 'parentId'];
}
