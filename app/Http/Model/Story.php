<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    //
    protected $table = "story";
    protected $primaryKey = "id";
    function images(){
        return $this->hasMany('App\Http\Model\StoryImage','storyId','id');
    }
}
