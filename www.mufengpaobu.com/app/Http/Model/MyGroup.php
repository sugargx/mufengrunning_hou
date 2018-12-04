<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class MyGroup extends Model
{
    //
    protected $table = "mygroup";
    protected $primaryKey = 'Id';
    public $timestamps = false;
}
