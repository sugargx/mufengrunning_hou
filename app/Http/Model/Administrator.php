<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;


class Administrator extends Model
{
    protected $table='administrator';
    protected $primaryKey='Id';
    public $timestamps=false;
}
