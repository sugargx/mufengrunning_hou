<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
require('org/cos-php-sdk/include.php');
use Qcloud\Cos\Api;
class UserController extends CommonController{
    //普通类型用户
    public function index()
    {
        $user=DB::table('usermain')
            ->paginate(25);
        $limit=DB::table('addlimit')
            ->first();
        return view('admin.user')->with(['data'=>$user,'limit'=> $limit]);
    }
    //查找
    public function create(){
        $input=Input::all();
        if($input['find-name']) {
            $name = DB::table('usermain')
                ->where('Name','like','%'.$input['find-name'].'%' )
                ->paginate(25);
            if ($name) {
                $limit=DB::table('addlimit')
                    ->first();
                return view('admin.user')->with(['data'=>$name,'limit'=> $limit]);
            } else {
                return back();
            }
        }
        elseif($input['find-city']){
            $city = DB::table('usermain')
                ->where('City','like','%'. $input['find-city'].'%')
                ->paginate(25);
            if ($city) {
                $limit=DB::table('addlimit')
                    ->first();
                return view('admin.user')->with(['data'=>$city,'limit'=> $limit]);
            } else {
                return back();
            }
        }
        else{
            return back();
        }
    }
    //用户删除
    public function destroy($Id){

        //图片删除方法
        $config = array(
            'app_id' => '1254292520',
            'secret_id' => 'AKIDLWS9cqaa6NPBi0uqOhkY8TYMuDG3dvyk',
            'secret_key' => 'kHZbO0OWO0MSIsCG8mBLGwNZWEixxiEV',
            'region' => 'bj',
            'timeout' => 60
        );
        $cosApi = new Api($config);
        $pic_name=DB::table('run')->where('UserMainID',$Id)->value('ImgUrl');
        if($pic_name){
            $find=explode(".com/", $pic_name)[1];
            $cosApi->delFile('mufengpaobu',$find );
        }
        //结束

        DB::table('run')->where('UserMainID',$Id)->delete();
        $re=DB::table('usermain')->where('Id',$Id)->delete();
        if($re){
            $data=[
                'status'=>0,
                'msg'=>'用户删除成功',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'用户删除失败，请稍后再试',
            ];
        }
        return $data;
    }
    public function limit()
    {
        DB::table('addlimit')->where('Id',1)->increment('GroupLimit');
        return redirect('admin/user');
    }
}
