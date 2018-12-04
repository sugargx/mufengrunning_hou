<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Groups;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
require('org/cos-php-sdk/include.php');

use Mockery\Exception;
use Qcloud\Cos\Api;


class GroupController extends CommonController
{
    //云存储模板
    public function image_config($id){
        $config = array(
            'app_id' => '1254292520',
            'secret_id' => 'AKIDLWS9cqaa6NPBi0uqOhkY8TYMuDG3dvyk',
            'secret_key' => 'kHZbO0OWO0MSIsCG8mBLGwNZWEixxiEV',
            'region' => 'bj',
            'timeout' => 60
        );
        $cosApi = new Api($config);
        $pic_name=DB::table('groups')->where('Id',$id)->value('ImgUrl');
        if($pic_name){
            $find=explode(".com/", $pic_name)[1];
            $cosApi->delFile('mufengpaobu',$find );
        }
    }
    public function index()
    {
        $groups = Groups::orderBy('State', 'asc')
            ->orderBy('AdvState', 'desc')
            ->paginate(20);
        return view('admin.group')->with('data', $groups);
    }
    //查找
    public function find()
    {
        $input = Input::all();
        if ($input['find-name']) {
            $name = Groups::where('GroupName','like','%'.$input['find-name'].'%' )
                ->paginate(10);
            if ($name) {
                return view('admin.group')->with('data', $name);
            } else {
                return back();
            }
        } elseif ($input['find-city']) {
            $city = Groups::where('City','like','%'. $input['find-city'].'%' )
                ->paginate(10);
            if ($city) {
                return view('admin.group')->with('data', $city);
            } else {
                return back();
            }
        } else {
            return back();
        }
    }
    //小程序模板推送
    function send_post( $url, $post_data ) {
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type:application/json',
                //header 需要设置为 JSON
                'content' => $post_data,
                'timeout' => 60
                //超时时间
            )
        );
        $context = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return $result;
    }
    //审核
    public function show($id)
    {
        $my_group=DB::table('MyGroup')
            ->where('GroupID',$id)
            ->where('Type',1)
            ->value('UserMainID');
        if(!$my_group){
            $data = [
                'msg' => '请联系客服',
            ];
            return $data;
        }
        $openid=DB::table('usermain')->where([
            ['Id',$my_group]
        ])->first();
        if(!$openid){
            $data = [
                'msg' => '团长不存在，请删除跑团',
            ];
            return $data;
        }
        $openid=$openid->openid;
        $form=DB::table('formid')->where([
            ['openid',$openid],
            ['State', 0],
        ])->first();
        if(!$form){
            DB::update('update groups set PeopleCount = ?,TotalDistance = ?,State = ? where Id = ?', [1, 0, 1, $id]);
            $data = [
                'msg' => '审核成功，模板消息未发出',
            ];

            return $data;
        }
        $form_id=$form->Id;
        $form_date=$form->date;
        $time=strtotime($form_date);
        if(date('Y-m-d h:i:s', $time) == date('Y-m-d h:i:s',time()-7*24*60*60)){
            DB::table('formid')
                ->where('Id',$form_id)
                ->delete();
            DB::update('update groups set PeopleCount = ?,TotalDistance = ?,State = ? where Id = ?', [1, 0, 1, $id]);
            $data = [
                'msg' => '审核成功，模板消息未发出',
            ];

            return $data;
        }else{
            //发送模板消息
            $formid=$form->formid;
            if($formid == "the formId is a mock one"){
                DB::table('formid')
                    ->where('Id',$form_id)
                    ->delete();
                DB::update('update groups set PeopleCount = ?,TotalDistance = ?,State = ? where Id = ?', [1, 0, 1, $id]);
                $data = [
                    'msg' => '审核成功，模板消息未发出',
                ];
                return $data;
            }else {
                $grouplogin = DB::table('grouplogin')->where('GroupId', $id)
                    ->first();
                $password = Crypt::decrypt($grouplogin->Pass);
                $appid = "wxa2a449343b9263dd";
                $appsecret = "ed0e07b2580bb7df72d8ea3bf7ef1e68";
                $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $appsecret;
                $html = file_get_contents($url);
                $output = json_decode($html, true);
                $access_token = $output['access_token'];
                $templateid = "fF0e4BDyzGQjxXcInbcCiUTV8Mv68utv_ayV-a74KqI";
                $answer=$grouplogin->User;
                $data_arr = array(
                    'keyword1' => array("value" => $answer, "color" => '#ccc'),
                    'keyword2' => array("value" => $password, "color" => '#ccc'),
                    'keyword3' => array("value" => 'https://www.mufengpaobu.com/login', "color" => '#ccc'),
                );

                $post_data = array(
                    "touser" => $openid,
                    //用户的 openID，可用过 wx.getUserInfo 获取
                    "template_id" => $templateid,
                    //小程序后台申请到的模板编号
                    "page" => "pages/index/runRun/teamIntroduce/teamIntroduce?Id=" . $id,
                    //点击模板消息后跳转到的页面，可以传递参数
                    "form_id" => $formid,
                    //第一步里获取到的 formID
                    "data" => $data_arr,
                    "emphasis_keyword" => "keyword2.DATA"
                    //需要强调的关键字，会加大居中显示
                );
                $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
                $data = json_encode($post_data, true);
                $return = $this->send_post($url, $data);
                DB::table('formid')
                    ->where('Id', $form_id)
                    ->delete();
                //发送结束
                DB::update('update groups set PeopleCount = ?,TotalDistance = ?,State = ? where Id = ?', [1, 0, 1, $id]);
                if ($return == 0) {
                    $data = [
                        'msg' => '审核成功,消息已推送',
                    ];
                } else {
                    $data = [
                        'msg' => '审核失败，请稍后再试',
                    ];
                }
                return $data;
            }
        }
    }
    //跑团未通过审核
    public function nopass($id)
    {
        //发送模板消息
        $my_group=DB::table('MyGroup')
            ->where('GroupID',$id)
            ->where('Type',1)
            ->value('UserMainID');
        $openid=DB::table('usermain')->where('Id',$my_group)->first();
        if(!$openid){
            $data = [
                'msg' => '团长不存在，请删除跑团',
            ];
            return $data;
        }
        $openid=$openid->openid;
        $form=DB::table('formid')->where([
            ['openid',$openid],
            ['State', 0],
        ])->first();
        if(!$form){
            DB::table('MyGroup')
                ->where('GroupID',$id)
                ->where('Type',1)
                ->delete();
            //删除图片
            $this->image_config($id);
            DB::table('groups')
                ->where('Id', $id)
                ->delete();


            DB::table('usermain')->where("Id",$my_group)->where('GroupNum','>',0)->decrement('GroupNum');
            $data = [
                'msg' => '移除成功，模板消息未发出',
            ];
            return $data;
        }
        $form_id=$form->Id;
        $formid=$form->formid;
        if($formid == "the formId is a mock one"){
            DB::table('formid')
                ->where('Id',$form_id)
                ->delete();
            DB::table('MyGroup')
                ->where('GroupID',$id)
                ->where('Type',1)
                ->delete();
            //删除图片
            $this->image_config($id);
            DB::table('groups')
                ->where('Id', $id)
                ->delete();
            DB::table('usermain')->where("Id",$my_group)->where('GroupNum','>',0)->decrement('GroupNum');

            $data = [
                'msg' => '移除成功，模板消息未发出',
            ];
            return $data;
        }else{
            $form_date=$form->date;
            $time=strtotime($form_date);
            if(date('Y-m-d h:i:s', $time) == date('Y-m-d h:i:s',time()-7*24*60*60)){
                DB::table('grouplogin')->where('GroupId',$id)
                    ->delete();
                DB::table('formid')
                    ->where('Id',$form_id)
                    ->delete();
                //发送结束
                DB::table('MyGroup')
                    ->where('GroupID',$id)
                    ->where('Type',1)
                    ->delete();
                //删除图片
                $this->image_config($id);
                DB::table('groups')
                    ->where('Id', $id)
                    ->delete();
                DB::table('usermain')->where("Id",$my_group)->where('GroupNum','>',0)->decrement('GroupNum');

                $data = [
                    'msg' => '移除成功，模板消息未发出',
                ];
                return $data;
            }else {
                DB::table('grouplogin')->where('GroupId', $id)
                    ->delete();
                $appid = "wxa2a449343b9263dd";
                $appsecret = "ed0e07b2580bb7df72d8ea3bf7ef1e68";
                $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $appsecret;
                $html = file_get_contents($url);
                $output = json_decode($html, true);
                $access_token = $output['access_token'];
                $templateid = "UwNHCUbYMmgOgwTINqfs22bfyT6uDtzGw3Ii92L7RN4";
                $data_arr = array(
                    'keyword1' => array("value" => "您创建的跑团未通过审核", "color" => '#ccc'),
                    'keyword2' => array("value" => "请检查您创建跑团的信息是否规范，或者重新申请创建跑团~", "color" => '#ccc'),
                );
                $post_data = array(
                    "touser" => $openid,
                    //用户的 openID，可用过 wx.getUserInfo 获取
                    "template_id" => $templateid,
                    //点击模板消息后跳转到的页面，可以传递参数
                    "form_id" => $formid,
                    //第一步里获取到的 formID
                    "data" => $data_arr,

                );

                $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
                $data = json_encode($post_data, true);
                $return = $this->send_post($url, $data);
                DB::table('formid')
                    ->where('Id', $form_id)
                    ->delete();
                //发送结束
                DB::table('MyGroup')
                    ->where('GroupID',$id)
                    ->where('Type',1)
                    ->delete();
                //删除图片
                try{
                    $this->image_config($id);
                }catch(Exception $e){}
                DB::table('groups')
                    ->where('Id', $id)
                    ->delete();
                DB::table('usermain')->where("Id",$my_group)->where('GroupNum','>',0)->decrement('GroupNum');
                if ($return == 0) {
                    $data = [
                        'msg' => '移出成功！',
                    ];
                } else {
                    $data = [
                        'msg' => '移出失败，请稍后再试',
                    ];
                }
                return $data;
            }
        }
    }
    //删除跑团
    public function destroy($Id)
    {
        $my_group=DB::table('MyGroup')
            ->where('GroupID',$Id)
            ->get();
        foreach($my_group as $k=> $v ){
           DB::table('usermain')
               ->where("Id",$v->UserMainID)
               ->where('GroupNum','>',0)
               ->decrement('GroupNum');
        }

        DB::table('MyGroup')
            ->where('GroupID',$Id)
            ->delete();
        DB::table('grouplogin')
            ->where('GroupId', $Id)
            ->delete();


        //删除图片
        $this->image_config($Id);
        $re = DB::table('groups')
            ->where('Id', $Id)
            ->delete();
        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '跑团删除成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '跑团删除失败，请稍后再试',
            ];
        }
        return $data;
    }
    //删除跑团广告位
    public function del_adv($Id)
    {
        $group = DB::table('advertise')
            ->where('Id', $Id)
            ->value('GroupID');

        DB::update('update groups set AdvState = ?,AdvId = ? where Id = ?', [0,0,$group]);
        //图片删除方法
        $config = array(
            'app_id' => '1254292520',
            'secret_id' => 'AKIDLWS9cqaa6NPBi0uqOhkY8TYMuDG3dvyk',
            'secret_key' => 'kHZbO0OWO0MSIsCG8mBLGwNZWEixxiEV',
            'region' => 'bj',
            'timeout' => 60
        );
        $cosApi = new Api($config);
        $pic_Img=DB::table('advertise')->where('Id', $Id)->value('AdvImgUrl');
        if($pic_Img){
            $findImg=explode(".com/", $pic_Img)[1];
            $cosApi->delFile('mufengpaobu',$findImg );
        }
        $pic_QR=DB::table('advertise')->where('Id', $Id)->value('AdvQRUrl');
        if($pic_QR){
            $findQR=explode(".com/", $pic_QR)[1];
            $cosApi->delFile('mufeng', $findQR);
        }

        //结束
        $re = DB::table('advertise')
            ->where('Id', $Id)
            ->delete();

        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '广告位删除成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '广告位删除失败，请稍后再试',
            ];
        }
        return $data;
    }
    //移出跑团成员
//    public function del_user($id)
//    {
//        $re = DB::table('MyGroup')
//            ->where('UserMainID', $id)
//            ->delete();
//        if ($re) {
//            $data = [
//                'status' => 0,
//                'msg' => '成员移出成功',
//            ];
//        } else {
//            $data = [
//                'status' => 1,
//                'msg' => '成员移出失败，请稍后再试',
//            ];
//        }
//        return $data;
//    }
    //禁用
    public function groupdisuse($id){
        DB::update('update groups set State = ? where Id = ?',[2, $id]);
        $data = [
            'msg' => '禁用跑团成功',
        ];
        return $data;
    }
    //解除禁用
    public function groupuse($id){
        DB::update('update groups set State = ? where Id = ?',[1, $id]);
        $data = [
            'msg' => '解除禁用成功',
        ];
        return $data;
    }

}
