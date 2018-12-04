<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
require('org/cos-php-sdk/include.php');
use Qcloud\Cos\Api;


class GroupIndexController extends CommonController
{
//跑团团长登录
//跑团信息
    public function show($groupname){
        //判断该跑团是否是此用户创建的(不能加：图片上传不了)
//        if((int)session('captain')!=(int)$groupname){
//            session(['captain'=>null]);
//            return redirect('login');
//        }
        //月统计折线图
        $begin=DB::table('groups')->where('Id',$groupname)->value('CreateDate');
        $time=strtotime($begin);
        //判断是否是同一年
        $data_month=array();
        //是同一年
        if(date('Y', $time) == date('Y',time())){
            for($i=(int)date('m', $time); $i <= date('m',time()); $i++) {
                $num=DB::table('run')
                    ->where('GroupID',$groupname)
                    ->whereYear('Date',date('Y',time()))
                    ->whereMonth('Date',$i)
                    ->count();
                $distance=DB::table('run')
                    ->where('GroupID',$groupname)
                    ->whereYear('Date',date('Y',time()))
                    ->whereMonth('Date',$i)
                    ->sum('Distance');
                $new=[
                    'time'=>"$i 月",
                    'num'=>$num,
                    'distance'=>$distance
                ];
                array_push($data_month,$new);
            }
        }else{
            for($i=1; $i <= date('m',time()); $i++) {
                $num=DB::table('run')
                    ->where('GroupID',$groupname)
                    ->whereYear('Date',date('Y',time()))
                    ->whereMonth('Date',$i)
                    ->count();
                $distance=DB::table('run')
                    ->where('GroupID',$groupname)
                    ->whereYear('Date',date('Y',time()))
                    ->whereMonth('Date',$i)
                    ->sum('Distance');
                $new=[
                    'time'=>"$i 月",
                    'num'=>$num,
                    'distance'=>$distance
                ];
                array_push($data_month,$new);
            }
        }
        //日统计折线图
        $begin=DB::table('groups')->where('Id',$groupname)->value('CreateDate');
        $time=strtotime($begin);
        //判断是否是同一年
        $data_day=array();
        //是同一年
        if(date('Y-m', $time) == date('Y-m',time())){
            for($i=(int)date('d', $time); $i <= date('d',time()); $i++) {
                $num=DB::table('run')
                    ->where('GroupID',$groupname)
                    ->whereYear('Date',date('Y',time()))
                    ->whereMonth('Date',date('m',time()))
                    ->whereDay('Date',$i)
                    ->count();
                $distance=DB::table('run')
                    ->where('GroupID',$groupname)
                    ->whereYear('Date',date('Y',time()))
                    ->whereMonth('Date',date('m',time()))
                    ->whereDay('Date',$i)
                    ->sum('Distance');
                $new=[
                    'time'=>"$i",
                    'num'=>$num,
                    'distance'=>$distance
                ];
                array_push($data_day,$new);
            }
        }else{
            for($i=1; $i <= date('d',time()); $i++) {
                $num=DB::table('run')
                    ->where('GroupID',$groupname)
                    ->whereYear('Date',date('Y',time()))
                    ->whereMonth('Date',date('m',time()))
                    ->whereDay('Date',$i)
                    ->count();
                $distance=DB::table('run')
                    ->where('GroupID',$groupname)
                    ->whereYear('Date',date('Y',time()))
                    ->whereMonth('Date',date('m',time()))
                    ->whereDay('Date',$i)
                    ->sum('Distance');
                $new=[
                    'time'=>"$i",
                    'num'=>$num,
                    'distance'=>$distance
                ];
                array_push($data_day,$new);
            }
        }
        //跑团信息
        $group=DB::table('groups')
            ->where('Id',$groupname)
            ->get();
        $advertise=DB::table('advertise')
            ->where('GroupID',$groupname)
            ->get();
        return view('admin.group.groupindex')->with([ 'pic_day'=>$data_day,'pic_month'=>$data_month,'group_data'=>$group,'adv_data'=>$advertise]);
    }
//跑团成员列举
    public function group_user($groupid)
    {
        if((int)session('captain')!=(int)$groupid){
            session(['captain'=>null]);
            return redirect('login');
        }

        $user=DB::table('MyGroup')
            ->where('GroupID',$groupid)
            ->paginate(25);


        foreach($user as $k=> $v ){
            $user1=DB::table('usermain')
                ->where("Id",$v->UserMainID)
                ->where('GroupNum','>',0)
                ->first();
            $v->Name = $user1->Name;
            $v->Sex = $user1->Sex;
            $v->Age = $user1->Age;
            $v->Tel = $user1->Tel;
            $v->TotalRun = $user1->TotalRun;
            $v->TotalPoints = $user1->TotalPoints;
            $v->Province = $user1->Province;
            $v->City = $user1->City;
            $v->District = $user1->District;
            $v->DetailedAddr = $user1->DetailedAddr;
            $v->RegisterDate = $user1->RegisterDate;
        }
        
        $group=DB::table('groups')
            ->where('Id',$groupid)
            ->get();
        return view('admin.group.grouppeople')->with([ 'user_data'=>$user,'group_data'=>$group]);
    }
//查看广告位
    public function group_advlook($groupid)
    {
        if((int)session('captain')!=(int)$groupid){
            session(['captain'=>null]);
            return redirect('login');
        }
        $data=DB::table('advertise')
            ->where('GroupID',$groupid)
            ->get();
        $group=DB::table('groups')
            ->where('Id',$groupid)
            ->get();
        return view('admin.group.groupchangeadvlook')->with(['adv_data'=>$data,'group_data'=>$group]);
    }
//删除跑团成员
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
//退出
    public function create(){
        session(['captain'=>null]);
        return redirect('login');
    }
//修改密码
    public function group_pass($groupid){
        if((int)session('captain')!=(int)$groupid){
            session(['captain'=>null]);
            return redirect('login');
        }
        if($input=Input::all()){
            $rules=[
                'user-new-pas'=>'between:8,16|confirmed',
            ];
            $message=[
                'user-new-pas.between'=>"*新密码必须在8-16位之间",
                'user-new-pas.confirmed'=>"*两次输入的新密码不一致",
            ];
            $group_re=Validator::make($input,$rules,$message) ;
            if($group_re->passes()){
                $group_pass=DB::table('grouplogin')
                    ->where('GroupId',$groupid)
                    ->value('Pass');
                $_password=Crypt::decrypt($group_pass);
                if($input['user-old-pas'] == $_password){
                    $group_pass=Crypt::encrypt($input['user-new-pas']);
                    DB::update('update grouplogin set Pass = ? where GroupId = ?', [$group_pass, $groupid]);
                    //方案1
                    session(['captain'=>null]);
                    return redirect('login');
                }else{
                    return back()->with('errors','原密码错误');
                }
            }else{
                return back()->withErrors($group_re);
            }
        }else{
            $group=DB::table('groups')
                ->where('Id',$groupid)
                ->get();
            return view('admin.group.groupchangepass')->with(['group_data'=>$group]);
        }
    }
//广告位编辑
    public function group_adv(Request $request,$groupid){
        if((int)session('captain')!=(int)$groupid){
            session(['captain'=>null]);
            return redirect('login');
        }
        if($input=Input::all()){
            $rules=[
                'adv-title'=>'between:0,10',
                'adv-control'=>'between:0,200',
                ];
            $message=[
                'adv-title.between'=>"*标题长度最多10个汉字",
                'adv-control.between'=>"*内容长度最多200个汉字",
            ];
            $validator=Validator::make($input,$rules,$message) ;
            if($validator->passes()) {
                //图片方法
                $config = array(
                    'app_id' => '1254292520',
                    'secret_id' => 'AKIDLWS9cqaa6NPBi0uqOhkY8TYMuDG3dvyk',
                    'secret_key' => 'kHZbO0OWO0MSIsCG8mBLGwNZWEixxiEV',
                    'region' => 'bj',
                    'timeout' => 60
                );
                $cosApi = new Api($config);
                //检验是否上传图片
                $file_adv = $request->advimg;
                if($file_adv) {
                    $entension = $file_adv->getClientOriginalExtension(); //上传文件的后缀.
                    $Name = date('YmdHis') . mt_rand(100, 999) . '.' . $entension;//重命名年月日时分秒+一个随机数
                    $newName = "/adv/$Name";
                    $bucket = 'mufengpaobu';
                    $dstPath = $file_adv;
                    $cosApi->upload($bucket, $dstPath, $newName);
//                    $result = $cosApi->stat('mufengpaobu',$newName );
//                    $adv=$result['data']['access_url'];
                    $file_adv="http://static.mufengpaobu.com$newName";
                }else{
                    return back()->with('errors','广告图片未上传');
                }
                //检验是否上传二维码
                $find_QR = $request->advQR;
                if($find_QR) {
                    $entension = $find_QR->getClientOriginalExtension(); //上传文件的后缀.
                    $Name = date('YmdHis') . mt_rand(100, 999) . '.' . $entension;//重命名年月日时分秒+一个随机数
                    $newName = "/adv/$Name";
                    $bucket = 'mufengpaobu';
                    $dstPath = $find_QR;
                    $cosApi->upload($bucket, $dstPath, $newName);
                    $find_QR="http://static.mufengpaobu.com$newName";
                }else{
                    return back()->with('errors','二维码未上传');
                }
                //结束
                DB::table('advertise')
                    ->insert(array('AdvTitle'=>$input['adv-title'],'Content'=>$input['adv-control'],'AdvImgUrl'=>$file_adv,'AdvQRUrl'=>$find_QR,'ExistDate'=>$input['adv-day'],'GroupId'=>$groupid));
                $adv_id=DB::table('advertise')
                    ->where('GroupId',$groupid)
                    ->value('Id');
                DB::update('update groups set AdvState = ?,AdvId = ? where Id = ?', [1,$adv_id,$groupid]);
                return redirect("group/groupindex/$groupid");
            }else{
                return back()->withErrors($validator);
            }
        }else{
            $group=DB::table('groups')
                ->where('Id',$groupid)
                ->get();
            return view('admin.group.groupchangeadv')->with(['group_data'=>$group]);
        }
    }
//图片上传
//    public function img_up()
//    {
//        $file = Input::file('Filedata');
//        if($file -> isValid()){
//            $config = array(
//                'app_id' => '1254050776',
//                'secret_id' => 'AKIDMbgX9WuW9XgaEdviOozwd5HEwOcblq67',
//                'secret_key' => 'vc3GEwOaWCbkdGdkcx50hANK0QZS4RXN',
//                'region' => 'sh',
//                'timeout' => 60
//            );
//            $cosApi = new Api($config);
//            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
//            $Name = date('YmdHis').mt_rand(100,999).'.'.$entension;//重命名年月日时分秒+一个随机数
//            $newName ="/adv/$Name";
//            $bucket = 'mufeng';
//            $dstPath = $file;
//
//            $cosApi->upload($bucket,$dstPath,$newName);
//            $result = $cosApi->stat('mufeng',$newName );
//            $find=$result['data']['access_url'];
//
////            $path = $file -> move(base_path().'/public/uploads/',$newName);//base_path()当前文件夹下的路径，‘.’起连接作用
//
//            return $find;
//
//        }
//    }
//每日跑量
    public function group_runs($id){
        if((int)session('captain')!=(int)$id){
            session(['captain'=>null]);
            return redirect('login');
        }
        $week=date('w',time());
        if( $week == 0){
            $user_day = DB::table('run')
                ->where('GroupID', $id)
                ->whereDate('Date','>',date('Y-m-d h:i:s',time()-7*24*60*60))
                ->whereDate('Date','<=',date('Y-m-d h:i:s',time()))
                ->orderBy('Date', 'desc')
                ->paginate(10);
        }else{
            $user_day = DB::table('run')
                ->where('GroupID', $id)
                ->whereDate('Date','>',date('Y-m-d h:i:s',time()-$week*24*60*60))
                ->orderBy('Date', 'desc')
                ->paginate(10);
        }
        $group=DB::table('groups')
            ->where('Id',$id)
            ->get();
        foreach($user_day as $k => $v) {
            $name=DB::table("usermain")->where('Id',$v->UserMainID)->value('Name');
            $v->Name=$name;
        }
        return view('admin.group.groupruns')->with(['day_data' => $user_day,'group_data'=>$group]);
    }
////小程序模板推送
//    function send_post( $url, $post_data ) {
//        $options = array(
//            'http' => array(
//                'method'  => 'POST',
//                'header'  => 'Content-type:application/json',
//                //header 需要设置为 JSON
//                'content' => $post_data,
//                'timeout' => 60
//                //超时时间
//            )
//        );
//        $context = stream_context_create( $options );
//        $result = file_get_contents( $url, false, $context );
//
//        return $result;
//    }
//同意入团
//    public function pass($id)
//    {
//        $user=DB::table('usermain')
//            ->where('Id',$id)
//            ->first();
//        $openid=$user->openid;
//        if(!$openid){
//            $data = [
//                'msg' => '团长不存在，请联系客服',
//            ];
//            return $data;
//        }
//        $form=DB::table('formid')->where([
//            ['openid',$openid],
//            ['State', 0],
//        ])->first();
//        if(!$form){
//            DB::table('usermain')
//                ->where('Id', $id)
//                ->update([
//                    'Type' => 0
//                ]);
//            $data = [
//                'msg' => '审核成功',
//            ];
//            return $data;
//        }
//        $form_id=$form->Id;
//        $time=strtotime($form->date);
//        if(date('Y-m-d h:i:s', $time) == date('Y-m-d h:i:s',time()-7*24*60*60)){
//            DB::table('formid')
//                ->where('Id',$form_id)
//                ->delete();
//            //发送结束
//            DB::table('usermain')
//                ->where('Id', $id)
//                ->update([
//                    'Type' => 0
//                ]);
//            $data = [
//                'msg' => '审核成功',
//            ];
//            return $data;
//        }else{
//            //发送模板消息
//            $formid=$form->formid;
//            if($formid == "the formId is a mock one"){
//                DB::table('formid')
//                    ->where('Id',$form_id)
//                    ->delete();
//                DB::table('usermain')
//                    ->where('Id', $id)
//                    ->update([
//                        'Type' => 0
//                    ]);
//                $data = [
//                    'msg' => '审核成功',
//                ];
//                return $data;
//            }else{
//                $form_id=$form->Id;
//                $appid="wxa2a449343b9263dd";
//                $appsecret="ed0e07b2580bb7df72d8ea3bf7ef1e68";
//                $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
//                $html = file_get_contents($url);
//                $output = json_decode($html, true);
//                $access_token = $output['access_token'];
//                $templateid='lCYJEHTxm9vijAXyYp59awXASqiN_tzbW5ER4bkCwzM';//给用户发送入团审核通过的模板
//                $group_tell=$user->GroupName;
//                $data_arr = array(
//                    'keyword1' => array( "value" => '您的入团申请已通过', "color" => '#ccc' ),
//                    'keyword2' => array( "value" => $group_tell, "color" => '#ccc' ),
//                );
//
//                $post_data = array (
//                    "touser"           => $openid,
//                    //用户的 openID，可用过 wx.getUserInfo 获取
//                    "template_id"      => $templateid,
//                    //小程序后台申请到的模板编号
//                    //           "page"             => "pages/index/runRun/teamIntroduce/teamIntroduce?Id=".$id,
//
//                    //点击模板消息后跳转到的页面，可以传递参数
//                    "form_id"          => $formid,
//                    //第一步里获取到的 formID
//                    "data"             => $data_arr,
//                    "emphasis_keyword" => "keyword2.DATA"
//                    //需要强调的关键字，会加大居中显示
//                );
//
//                $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token;
//                $data = json_encode($post_data, true);
//                $return = $this->send_post( $url, $data);
//                DB::table('formid')
//                    ->where('Id',$form_id)
//                    ->delete();
//                //发送结束
//                DB::table('usermain')
//                    ->where('Id', $id)
//                    ->update([
//                        'Type' => 0
//                    ]);
//                if($return==0){
//                    $data = [
//                        'msg' => '审核成功',
//                    ];
//                }else{
//                    $data = [
//                        'msg' => '审核失败，请稍后再试',
//                    ];
//                }
//                return $data;
//            }
//        }
//    }
////不同意入团
//    public function nopass($id)
//    {
//        $user=DB::table('usermain')
//            ->where('Id',$id)
//            ->first();
//        $openid=$user->openid;
//        if(!$openid){
//            $data = [
//                'msg' => '用户不存在，请联系客服',
//            ];
//            return $data;
//        }
//        $form=DB::table('formid')->where([
//            ['openid',$openid],
//            ['State', 0],
//        ])->first();
//        if(!$form){
//            DB::table('usermain')
//                ->where('Id', $id)
//                ->update([
//                    'Type' => 0,
//                    'GroupName' => null,
//                    'GroupID' => 0
//                ]);
//            $data = [
//                'msg' => '操作成功',
//            ];
//            return $data;
//        }
//        $form_id=$form->Id;
//        $time=strtotime($form->date);
//        if(date('Y-m-d h:i:s', $time) == date('Y-m-d h:i:s',time()-7*24*60*60)){
//            DB::table('formid')
//                ->where('Id',$form_id)
//                ->delete();
//            //发送结束
//            DB::table('usermain')
//                ->where('Id', $id)
//                ->update([
//                    'Type' => 0,
//                    'GroupName' => null,
//                    'GroupID' => 0
//                ]);
//            $data = [
//                'msg' => '操作成功',
//            ];
//            return $data;
//        }else{
//            //发送模板消息
//            $formid=$form->formid;
//            if($formid == "the formId is a mock one"){
//                DB::table('formid')
//                    ->where('Id',$form_id)
//                    ->delete();
//                DB::table('usermain')
//                    ->where('Id', $id)
//                    ->update([
//                        'Type' => 0,
//                        'GroupName' => null,
//                        'GroupID' => 0
//                    ]);
//                $data = [
//                    'msg' => '操作成功',
//                ];
//                return $data;
//            }else {
//                $form_id = $form->Id;
//                $appid = "wxa2a449343b9263dd";
//                $appsecret = "ed0e07b2580bb7df72d8ea3bf7ef1e68";
//                $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $appsecret;
//                $html = file_get_contents($url);
//                $output = json_decode($html, true);
//                $access_token = $output['access_token'];
//                $templateid = 'lCYJEHTxm9vijAXyYp59awXASqiN_tzbW5ER4bkCwzM';//给用户发送入团审核通过的模板
//                $group_tell=$user->GroupName;
//                $data_arr = array(
//                    'keyword1' => array("value" => '此跑团团长拒绝您的加入', "color" => '#ccc'),
//                    'keyword2' => array("value" => $group_tell, "color" => '#ccc'),
//                );
//
//                $post_data = array(
//                    "touser" => $openid,
//                    //用户的 openID，可用过 wx.getUserInfo 获取
//                    "template_id" => $templateid,
//                    //小程序后台申请到的模板编号
//                    //           "page"             => "pages/index/runRun/teamIntroduce/teamIntroduce?Id=".$id,
//
//                    //点击模板消息后跳转到的页面，可以传递参数
//                    "form_id" => $formid,
//                    //第一步里获取到的 formID
//                    "data" => $data_arr,
//                    "emphasis_keyword" => "keyword2.DATA"
//                    //需要强调的关键字，会加大居中显示
//                );
//
//                $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $access_token;
//                $data = json_encode($post_data, true);
//                $return = $this->send_post($url, $data);
//                DB::table('formid')
//                    ->where('Id', $form_id)
//                    ->delete();
//                //发送结束
//                DB::table('usermain')
//                    ->where('Id', $id)
//                    ->update([
//                        'Type' => 0,
//                        'GroupName' => null,
//                        'GroupID' => 0
//                    ]);
//                if ($return == 0) {
//                    $data = [
//                        'msg' => '操作成功',
//                    ];
//                } else {
//                    $data = [
//                        'msg' => '操作失败，请稍后再试',
//                    ];
//                }
//                return $data;
//            }
//        }
//    }
//积分减扣
    public function points_down($id,$points){
        $points < 0 ? $points=-$points : $points=$points;
        $totalPoints=DB::table('usermain')
            ->where('Id',$id)
            ->value('TotalPoints');
        $totalPoints=$totalPoints-$points;
        if($totalPoints<0){
            $totalPoints=0;
        }
        $re = DB::table('usermain')
            ->where('Id', $id)
            ->update([
                'TotalPoints' => $totalPoints
            ]);


        if ($re) {
            $data = [
                'status' => 0,
                'msg' => '积分扣除成功',
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '积分扣除失败，请确认输入是否正确',
            ];
        }
        return $data;
    }
}
