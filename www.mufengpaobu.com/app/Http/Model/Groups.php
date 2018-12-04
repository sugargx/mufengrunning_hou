<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;


class Groups extends Model
{
    protected $table='groups';
    protected $primaryKey='Id';
    public $timestamps=false;
}
