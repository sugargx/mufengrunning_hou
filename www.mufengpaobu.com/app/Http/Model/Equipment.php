<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    //
    protected $table = 'equipment';
    protected $primaryKey = "id";
    function images(){
        return $this->hasMany('App\Http\Model\EquipmentImage','equipmentId','id');
    }
}
