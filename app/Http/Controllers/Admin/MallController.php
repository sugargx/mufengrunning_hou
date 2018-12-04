<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class MallController extends CommonController{
    public function index()
    {
        return view('admin.mall');
    }
}
