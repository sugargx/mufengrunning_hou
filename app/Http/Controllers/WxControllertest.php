<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\Storage;
use Overtrue\Pinyin\Pinyin;
require('org/cos-php-sdk/include.php');
use Qcloud\Cos\Api;
class WxControllertest extends Controller
{
    public function uploadimg(Request $request){
        dd($request->File);
    }
}















