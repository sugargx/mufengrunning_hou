<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
require('org/cos-php-sdk/include.php');
use Qcloud\Cos\Api;

class CarouselController extends CommonController{
//    get.admin/carousel
    public function index()
    {
        $carousel=DB::table('carousel')
            ->orderBy('Id', 'desc')
            ->paginate(4);
        return view('admin.carousel')->with('data',$carousel);
    }
    //上传轮播图
    public function store(){
        $input=Input::all();
        if(!$input['adv-img-val']||!$input['adv-QR-val']){
            return back()->with('msg', '上传图片前请将浏览器设置中的flash设置项设为“允许网站运行”状态');
        }
        if(!$input['carousel-name']){
            $input['carousel-name']="默认标题";
        }
        DB::table('carousel')
            ->insert(array('Id'=>$input['carousel-id'],'CarName'=>$input['carousel-name'],'CarUrl'=>$input['carousel-img']));
        return back();
    }
    //删除轮播图
    public function del($id){
        //图片删除方法
        $config = array(
            'app_id' => '1254292520',
            'secret_id' => 'AKIDLWS9cqaa6NPBi0uqOhkY8TYMuDG3dvyk',
            'secret_key' => 'kHZbO0OWO0MSIsCG8mBLGwNZWEixxiEV',
            'region' => 'bj',
            'timeout' => 60
        );
        $cosApi = new Api($config);
        $pic_name=DB::table('carousel')->where('Id',1)->value('CarUrl');
        $find=explode(".com/", $pic_name)[1];
        $cosApi->delFile('mufeng',$find );
        //结束

        $re=DB::table('carousel')
            ->where('Id',$id)
            ->delete();
        if($re){
            $data=[
                'status'=>0,
                'msg'=>'轮播图删除成功',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'轮播图删除失败，请稍后再试',
            ];
        }
        return $data;
    }
}
