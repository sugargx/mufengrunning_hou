<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Administrator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
require_once 'org/code/Code.class.php';

class LoginController extends CommonController{
    public function login(){
//        表单中有提交值
        if($input=Input::all()){
//            Input::all(),是获得前端页面表单所有信息
            $code=new \Code;
            $_code=$code->get();
            if(strtoupper($input['form-code']) != $_code){

                return back()->with('msg', '验证码错误' ) ;
            }
            $administrator = Administrator::first();
            if($administrator->Account == $input['form-username']){
                if (Crypt::decrypt($administrator->Password) != $input['form-password']) {
                    return back()->with('msg', '用户名或密码错误');
                }
                session(['administrator' => $administrator]);
                //            跳转到某个页面
                return redirect('admin/index');
            }else{
                $captain = DB::table('grouplogin')
                    ->where('User',$input['form-username'])
                    ->first();
                if(!$captain){
                    return back()->with('msg','用户名错误');
                }
                if (Crypt::decrypt($captain->Pass) != $input['form-password']) {
                    return back()->with('msg', '密码错误');
                }
                session(['captain' => $captain->GroupId]);
                //            跳转到某个页面
                return redirect("group/groupindex/$captain->GroupId");
            }
        }else{
//            表单中没提交值
            return view('admin.login');
        }
    }

    //二维码
    public function code(){
        $code=new \Code;
        $code->make();
    }

}
