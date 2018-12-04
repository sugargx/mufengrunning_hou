<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class UserMain extends Model
{
    //
    protected $table = "usermain";
    public $timestamps = false;
    protected $primaryKey = 'Id';

    function groups(){
        return $this->belongsToMany('App\Http\Model\Groups','mygroup','UserMainID','GroupID');
    }
}
