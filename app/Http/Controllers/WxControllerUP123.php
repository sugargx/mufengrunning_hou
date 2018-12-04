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
class WxControllerUP extends Controller
{
//    public function CLearZHANGDI(){
//        DB::table('usermain')->where('openid',"o-UIQ0ZnFnprotgwSrqEFjkSCrpM")->update([
//            "Name"=>null,
//            "GroupNum"=>0,
//            "Type"=>0,
//            "GroupID"=>0,
//            "GroupName"=>null,
//            "Rank"=>1,
//            "Speed"=>0,
//            "District"=>null,
//            "TotalRun"=>0,
//            "TotalPoints"=>0,
//            "Tel"=>null,
//            "Age"=>null,
//            "Sex"=>null,
//            "City"=>null,
//            "DetailedAddr"=>null,
//            "Province"=>null,
//            "ReportNum"=>0,
//        ]);
//        $Id=DB::table('usermain')->where('openid',"o-UIQ0ZnFnprotgwSrqEFjkSCrpM")->first()->Id;
//        $Run=DB::table('run')->where('UserMainID',$Id)->select('Id',"ImgUrl")->get();
//        foreach($Run as $item){
//            $imgUrl=$item->ImgUrl;
//            $bucket = 'mufengpaobu';
//            $imgUrl=explode('mufengpaobu.com',$imgUrl)[1];
//            $cosApi = new Api($this->config());
//            $result1 = $cosApi->delFile($bucket, $imgUrl);
//            DB::table('run')->where('Id',$item->Id)->delete();
//        }
//    }
    function removeDatebase($ID){
//        $Id=$ID;
//        $MyGroup=DB::table('usermain')->where('Id',$Id)->where('GroupID','>',0)->where('GroupNum',0)->select('Id','GroupID','Type','GroupName')->first();
//        if($MyGroup){
//            $res1=DB::table('MyGroup')->where([
//                'GroupID'=>$MyGroup->GroupID,
//                'UserMainID'=>$MyGroup->Id,
//                'Type'=>$MyGroup->Type,
//                'GroupName'=>$MyGroup->GroupName,
//            ])->first();
//            if(!$res1){
//                $res2=DB::table('MyGroup')->insert([
//                    'GroupID'=>$MyGroup->GroupID,
//                    'UserMainID'=>$MyGroup->Id,
//                    'Type'=>$MyGroup->Type,
//                    'GroupName'=>$MyGroup->GroupName,
//                ]);
//                if($res2){
//                    $res3=DB::table('usermain')->where('GroupID','>',0)->update(['GroupNum'=>1]);
//                    if($res3) return 'true';
//                    else return 'false';
//                }
//            }
//        }
//        return 'false';
    }
    public function GroupMOvE(){
//        DB::table('usermain')->where('GroupID','>',0)->update(['GroupNum'=>1]);
//        DB::table('usermain')->update(['GroupNum'=>0]);
//        $Group=DB::table('usermain')->where('GroupID','>',0)->select('Id','GroupID','GroupName','Type')->get();
//        foreach($Group as $item){
//            $flag=DB::table('MyGroup')->where([
//                'GroupID'=>$item->GroupID,
//                'UserMainID'=>$item->Id,
//            ])->first();
//            if($flag){
//                DB::table('MyGroup')->where([
//                    'GroupID'=>$item->GroupID,
//                    'UserMainID'=>$item->Id,
//                ])->update([
//                    'GroupName'=>$item->GroupName,
//                    'Type'=>$item->Type
//                ]);
//            }else{
//                DB::table('MyGroup')->insert([
//                    'GroupID'=>$item->GroupID,
//                    'UserMainID'=>$item->Id,
//                    'GroupName'=>$item->GroupName,
//                    'Type'=>$item->Type
//                ]);
//            }
//        }
    }
    var $URL="http://static.mufengpaobu.com";
    //封装方法：从接口中获取内容
    function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    function config(){
        //沐风跑步账号的配置
        return array(
            'app_id' => '1254292520',
            'secret_id' => 'AKIDLWS9cqaa6NPBi0uqOhkY8TYMuDG3dvyk',
            'secret_key' => 'kHZbO0OWO0MSIsCG8mBLGwNZWEixxiEV',
            'region' => 'bj',
            'timeout' => 60
        );
//        return array(
//            'app_id' => '1254050776',
//            'secret_id' => 'AKIDMbgX9WuW9XgaEdviOozwd5HEwOcblq67',
//            'secret_key' => 'vc3GEwOaWCbkdGdkcx50hANK0QZS4RXN',
//            'region' => 'sh',
//            'timeout' => 60
//        );
//        return array(
//            'app_id' => '1252495372',
//            'secret_id' => 'AKIDS4b58CW4ykKjy2rZ3b9hEhy3yqeInASa',
//            'secret_key' => 'mS3hDbprg4PYXKwRl4GG6kDUxT0UuETh',
//            'region' => 'ap-beijing',
//            'timeout' => 60
//        );
    }
    public function index(Request $request)
    {
        $code = $request->code;
        $APPID = 'wxa2a449343b9263dd';
        $SECRET = 'ed0e07b2580bb7df72d8ea3bf7ef1e68';
        $api = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $APPID . '&secret=' . $SECRET . '&js_code=' . $code . '&grant_type=authorization_code'; //调用官方接口
        $str = $this->httpGet($api); //执行方法：从接口中获取内容（json格式）
        $arr = json_decode($str,true); //后面加true转换为数组
        $users = DB::table('usermain')->where('openid',$arr['openid'])->first();
        if (!$users){//如果没找到，需要插入新的
            $result=DB::table('usermain')->insert(
                [
                    'openid' => $arr['openid'],
                ]
            );
        }
        $userInfo=DB::table('usermain')->where('openid',$arr['openid'])->first();
        /*新版本数据迁移开始*/
//        $this->removeDatebase($userInfo->Id);
        /*数据迁移结束*/
        $ID=$userInfo->Id;
        $flag=($userInfo->Name!='');//标记是否已经完善姓名、年龄、家庭住址、性别、电话个人基本信息
        return ['registerFlag'=>$flag,'GroupNum'=>$userInfo->GroupNum,'Id'=>$userInfo->Id];
    }
    //获取用户基本信息，初始化程序
    public function getopenid(Request $request)
    {
        $code = $request->code;
        $APPID = 'wxa2a449343b9263dd';
        $SECRET = 'ed0e07b2580bb7df72d8ea3bf7ef1e68';

        $HeadImgUrl = $request->HeadImgUrl;
        $NickName = $request->NickName;

        $api = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $APPID . '&secret=' . $SECRET . '&js_code=' . $code . '&grant_type=authorization_code'; //调用官方接口
//        echo $api;
        $str = $this->httpGet($api); //执行方法：从接口中获取内容（json格式）
//        var_dump($str);
        $arr = json_decode($str,true); //后面加true转换为数组
        //从数据库获取加入跑团的数量限制
        $addlimit=DB::table('addlimit')->first()->GroupLimit;
//        $addlimit=3;
        $users = DB::table('usermain')->where('openid',$arr['openid'])->first();
        if (!$users){//如果没找到，需要插入新的
            $result=DB::table('usermain')->insert(
                [
                    'openid' => $arr['openid'],
                    'NickName' => $NickName,
                    'HeadImgUrl' => $HeadImgUrl
                ]
            );
        }else{//如果找到了，要先更新数据
            DB::table('usermain')
                ->where('openid', $arr['openid'])
                ->update([
                    'NickName' => $NickName,
                    'HeadImgUrl' => $HeadImgUrl
                ]);
        }
//        $flag=false;
        $userInfo=DB::table('usermain')->where('openid',$arr['openid'])->first();
        /*新版本数据迁移开始*/
//        $this->removeDatebase($userInfo->Id);
        /*数据迁移结束*/
        $MyGroup=DB::table('MyGroup')->where('UserMainID',$userInfo->Id)->get();
        foreach($MyGroup as $item){
            $item->GroupState=DB::table('groups')->where('Id',$item->GroupID)->first()->State;
        }
        $ID=$userInfo->Id;
        $flag=($userInfo->Name!='');//标记是否已经完善姓名、年龄、家庭住址、性别、电话个人基本信息
        $DateNow=date("Y-m-d",time());//获取今天的时间戳
        $UploadRunFlag=DB::table("run")->whereDate('Date',$DateNow)->where('UserMainID',$ID)->count();
        $UploadRunFlag=($UploadRunFlag!=0);
        if($flag){
            return [['openid'=>$arr['openid'],'Id'=>$ID,'MyGroup'=>$MyGroup],['registerFlag'=>$flag,$userInfo,'addlimit'=>$addlimit,'UploadRunFlag'=>$UploadRunFlag]];
        }else return [['openid'=>$arr['openid'],'Id'=>$ID,'MyGroup'=>$MyGroup],['registerFlag'=>$flag,'addlimit'=>$addlimit,'UploadRunFlag'=>$UploadRunFlag]];
    }
    //获取首页图片(第一版)
    public function getImg(){
        $getImg=DB::table('carousel')->where('Id','<',4)->select('CarUrl')->get();
        return $getImg;
    }
    //获取首页总跑量、总人数信息(第二版)
    public function getIndex(){
        $totalDis=DB::table('run')->sum('Distance');//总跑量
        $totalDis=round($totalDis ,2);
//        $totalGroups=DB::table('groups')->where('State',1)->count();//总跑团量
        $totalPeople=DB::table('usermain')->count();//总人数
        return [$totalDis,$totalPeople];
    }
    public function getApplicants(Request $request){//获取所有申请人的信息
        $groupId=$request->GroupId;
        $applicants=DB::table('MyGroup')->where('GroupID',$groupId)->where('Type',3)->select('UserMainID')->get();
        foreach($applicants as $item){
            $app=DB::table('usermain')->where('Id',$item->UserMainID)->first();
            foreach($app as $key=>$value){
                $item->$key=$value;
            }
        }
        return $applicants;
    }
    public function getGroupInfo(Request $request){
        $groupId=$request->GroupID;
        $groups=DB::table('groups')->where('Id',$groupId)->get();
        return $groups;
    }
    //获取首页我的总跑量、我的跑步次数信息
    public function getMy(Request $request){
        $Id=$request->Id;
//        $token=$request->token;
        $MyDis=DB::table('usermain')->where('Id',$Id)->first()->TotalRun;
        $MyTime=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Id)->count();
        return [$MyDis,$MyTime];
    }
    //团长获取跑团状态，查看是否通过审核
    public function getMyGroupState(Request $request){
        $GroupId=$request->GroupId;
//        return json_encode($Id)[0];
        $GroupId=json_decode($GroupId,true);

        for($i=0;$i<count($GroupId);$i++){
            $state=DB::table('groups')->where('Id',$GroupId[$i])->select()->first()->State==1;
            $num=DB::table('MyGroup')->where([
                'GroupID'=>$GroupId[$i],
                'Type'=>3
            ])->count();
           if($state&&$num) return 'true';
        }
        return 'false';
    }
    public function getMyGroupList(Request $request){
        $GroupId=$request->GroupId;
        $Status=$request->Status;
        $GroupState=$request->GroupState;
//        return json_encode($Id)[0];
        $GroupId=json_decode($GroupId,true);
        $Status=json_decode($Status,true);
        $GroupState=json_decode($GroupState,true);
        $MyGroup=array();
        for($i=0;$i<count($GroupId);$i++){
            $Group=DB::table('groups')->where('Id',$GroupId[$i])->first();
            if($Group) {
                $time=date('Y-m-d',time()-30*24*60*60);//筛选前30天的跑量
                $Group->TotalDistance=DB::table('run')->where('GroupID',$GroupId[$i])->whereDate('Date','>',$time)->sum('Distance');
                $Group->TotalDistance=round($Group->TotalDistance,2);
                $Group->manage=($Status[$i]==1&&$GroupState[$i]==1)?true:false;
                $Group->checking=($Status[$i]==1&&$GroupState[$i]==0)?true:false;
                $Group->joining=($Status[$i]==3)?true:false;
                if($Status[$i]==1&&$GroupState[$i]==1){
                    $Group->Apply=DB::table('MyGroup')->where([
                        'GroupID'=>$GroupId[$i],
                        'Type'=>3
                    ])->count()>0?true:false;
                }else{
                    $Group->Apply=false;
                }

                array_push($MyGroup,$Group);
            }

        }
        return $MyGroup;
    }
    //搜索附近跑团
    public function runGroup(Request $request){

        $xJd=$request->Jd;//经度
        $yWd=$request->Wd;//纬度
        $jl_jd = 102834.7425802608978601367747628;
        $jl_wd = 111712.6915064105572998430141287;
        $num=15;
        $skip=($request->page-1)*$num;
//        return $skip;
        $nearbyGroup = DB::select('select *,floor(sqrt(power((latitude-:yWd)*:jl_wd,2)+power((longitude-:xJd)*:jl_jd,2))/50)*50 as Distance from groups where State=1 order by Distance asc,TotalDistance desc LimiT :skip,:num', ['yWd' => $yWd,'xJd'=>$xJd,'jl_jd'=>$jl_jd,'jl_wd'=>$jl_wd,'skip'=>$skip,'num'=>$num]);//将已通过审核的跑团按照距离从进到远排序，若距离相同则按照从跑量从多到少排序
        foreach ($nearbyGroup as $item) {
            if($item->Distance<100) $item->Distance=100;
            $GroupId=$item->Id;//存入月跑量
//            $item->TotalDistance1=DB::table('run')->where('GroupID',$GroupId)->whereYear('Date',date('Y',time()))->whereMonth('Date',date('m',time()))->sum('Distance');
            $time=date('Y-m-d',time()-30*24*60*60);//筛选前30天的跑量
            $item->TotalDistance=DB::table('run')->where('GroupID',$GroupId)->whereDate('Date','>',$time)->sum('Distance');
            $item->TotalDistance=round($item->TotalDistance,2);
        }
        return $nearbyGroup;
    }
    //搜索全国跑团
    public function allGroup(Request $request){
        $num=15;
        $skip=($request->page-1)*$num;
        $allGroup=DB::table('groups')->where([
            ['State',1]//通过审核
        ])->orderBy('TotalDistance', 'desc')->skip($skip)->take($num)->get();//将跑团按照跑量降序排序
        foreach ($allGroup as $item) {
            $GroupId=$item->Id;//存入月跑量
            $time=date('Y-m-d',time()-30*24*60*60);//筛选前30天的跑量
            $item->TotalDistance=DB::table('run')->where('GroupID',$GroupId)->whereDate('Date','>',$time)->sum('Distance');
            $item->TotalDistance=round($item->TotalDistance,2);
        }
        return $allGroup;
    }
    //获取我的入团状态
    public function getMyState(Request $request){
        $Id=$request->Id;
        $token=$request->token;
        $my=DB::table('usermain')->where('Id',$Id)->select('GroupID','GroupName','Type')->first();
        return [$my];
    }
    //跑团介绍
    public function teamIntroduce(Request $request){
        $Id=$request->teamId;
//        return '新页面的ID是：：：：'.$Id;
        $teamIntroduce = DB::table('groups')->where('Id',$Id)->get();
        foreach($teamIntroduce as $k => $v){
            $v->TotalDistance=round($v->TotalDistance,2);
        }
        $GroupID=$Id;
        $DateNow=date("Y-m-d",time());//获取当前时间
//        dd($DateNow);//"2017-08-12"
//        $run=DB::table("run")->whereDate('Date',$DateNow)->where('GroupID',$GroupID)->where('TotalDis','>',0)->orderBy('TotalDis', 'desc')->orderBy('TotalTimeLong', 'asc')->select('TotalDis', 'TotalTimeLong','UserMainID')->get();//找到当前时间，加入指定跑团，按照跑步距离从高到低排序，若距离相等从按跑步时间从低到高排序，在run这个表中，只用选择出跑步里程、跑步时间和跑者的id就行了。
        $run=DB::table("run")->whereDate('Date',$DateNow)->where('GroupID',$GroupID)->where('TotalDis','>',0)->select('TotalDis', 'TotalTimeLong','UserMainID')->get();//找到当前时间，加入指定跑团，按照跑步距离从高到低排序，若距离相等从按跑步时间从低到高排序，在run这个表中，只用选择出跑步里程、跑步时间和跑者的id就行了。

//        $row=$run->count();//获取行数
        foreach($run as $k => $v){//在Model对象中添加headImgUrl和NickName键值和值
            $HeadImgUrl=DB::table("usermain")->where('Id',$v->UserMainID)->select('HeadImgUrl')->first();
            $v->TotalDis=round($v->TotalDis,2);
            //先编码成json字符串，再解码成数组
            $v->HeadImgUrl=json_decode(json_encode($HeadImgUrl), true)['HeadImgUrl'];
            $NickName=DB::table("usermain")->where('Id',$v->UserMainID)->select('NickName')->first();
            $v->NickName=json_decode(json_encode($NickName), true)['NickName'];
            $v->Hour=floor($v->TotalTimeLong/3600);
            $v->Minute=round(($v->TotalTimeLong%3600)/60);
            //注意：我们在使用laravel的eloquent ORM 对数据库进行CRUD操作时，返回给我们的结果不是像TP(3.2版本)那样返回一个数组，而是返回一个对象，但是往往我们需要的是一个数组，这样更好处理数据，这里提供一个简便的方法（先编码成json字符串，再解码成数组）。
        }
//        dd(json_decode(json_encode($run), true));
        //获取广告位：v1.0.6上线后删掉在这里获取广告位的方法
        $adv=DB::table('advertise')->where('GroupID',$GroupID)->first();
        if($adv){//如果有广告位
            $flag=(time()<(strtotime($adv->UploadDate)+($adv->ExistDate)*24*60*60));
            if(!$flag){//如果过期
                $adv=DB::table('advertise')->where('GroupID',0)->first();
            }
        }else{
            $adv=DB::table('advertise')->where('GroupID',0)->first();
        }
        return [$teamIntroduce,$run,$adv];
    }
    public function dismissGroup(Request $request){
        $Id=$request->Id;
        $GroupId=$request->GroupId;
        $check=DB::table("MyGroup")->where([
            'UserMainID'=>$Id,
            'GroupID'=>$GroupId,
            'Type'=>1
        ])->count();
        if($check){
            $userId=DB::table("MyGroup")->where('GroupID',$GroupId)->select('UserMainID')->get();
            $de1=DB::table("MyGroup")->where('GroupID',$GroupId)->delete();
            $de2=DB::table("groups")->where('Id',$GroupId)->delete();
            foreach($userId as $item){
                $de3=DB::table("usermain")->where("Id",$item->UserMainID)->where("GroupNum",">",0)->decrement('GroupNum');
            }
            if($de1&&$de2) return 'true';
        }
        return 'false';
    }
    public function rankList(Request $request){
        $Id=$request->teamId;
        $GroupID=$Id;
        $DateNow=date("Y-m-d",time());//获取当前时间
        $run=DB::table("run")->whereDate('Date',$DateNow)->where('GroupID',$GroupID)->where('TotalDis','>',0)->orderBy('TotalDis', 'desc')->orderBy('TotalTimeLong', 'asc')->select('TotalDis', 'TotalTimeLong','UserMainID')->get();//找到当前时间，加入指定跑团，按照跑步距离从高到低排序，若距离相等从按跑步时间从低到高排序，在run这个表中，只用选择出跑步里程、跑步时间和跑者的id就行了。
        foreach($run as $k => $v){//在Model对象中添加headImgUrl和NickName键值和值
            $HeadImgUrl=DB::table("usermain")->where('Id',$v->UserMainID)->select('HeadImgUrl')->first();
            $v->TotalDis=round($v->TotalDis,2);
            //先编码成json字符串，再解码成数组
            $v->HeadImgUrl=json_decode(json_encode($HeadImgUrl), true)['HeadImgUrl'];
            $NickName=DB::table("usermain")->where('Id',$v->UserMainID)->select('NickName')->first();
            $v->NickName=json_decode(json_encode($NickName), true)['NickName'];
            $v->Hour=floor($v->TotalTimeLong/3600);
            $v->Minute=round(($v->TotalTimeLong%3600)/60);
            //注意：我们在使用laravel的eloquent ORM 对数据库进行CRUD操作时，返回给我们的结果不是像TP(3.2版本)那样返回一个数组，而是返回一个对象，但是往往我们需要的是一个数组，这样更好处理数据，这里提供一个简便的方法（先编码成json字符串，再解码成数组）。
        }
        $teamIntroduce=null;
        return [$teamIntroduce,$run];
    }
    //获取跑团广告位
    public function getAdv(Request $request){
        $GroupID=$request->GroupID;
        $adv=DB::table('advertise')->where('GroupID',$GroupID)->first();

        if($adv){//如果有广告位

            $flag=(time()<(strtotime($adv->UploadDate)+($adv->ExistDate)*24*60*60));
            if(!$flag){//如果过期
                $adv=DB::table('advertise')->where('GroupID',0)->first();
            }
        }else{

            $adv=DB::table('advertise')->where('GroupID',0)->first();
        }

        return [$adv];
    }
    //上传或修改用户信息
    public function uploaduserinfo(Request $request){
        $openid= $request->openid;
//        $user = DB::table('usermain')->where('openid',$openid)->first();
//        if($user->Name!=''){//用户已经完善过信息
            $result=DB::table('usermain')
                ->where('openid',$openid)
                ->update([
                    'Name' => $request->Name,
                    'Age' => $request->Age,
                    'Sex' => $request->Sex,
                    'Tel' => $request->Tel,
                    'Speed' => $request->Speed,
                    'Province' => $request->Province,
                    'City' => $request->City,
                    'District' => $request->District,
                    'DetailedAddr' => $request->DetailedAddr,
                ]);
            if($result) return 'true';
//            else  return false;
//        }else{
//            $res1=DB::table('usermain')->insert([
//                'Name' => $request->Name,
//                'Age' => $request->Age,
//                'Sex' => $request->Sex,
//                'Tel' => $request->Tel,
//                'Province' => $request->Province,
//                'City' => $request->City,
//                'District' => $request->District,
//                'DetailedAddr' => $request->DetailedAddr,
//            ]
//            );
//            if($res1) return '用户信息添加成功！！！！！';
//            else return '用户信息添加失败！！！！！';
//        }

    }
    //创建跑团之前先验证跑团名称是否存在
    public function checkName(Request $request){
        return DB::table('groups')->where('GroupName',$request->GroupName)->count();
    }
    //创建跑团
    public function creatGroup(Request $request)
    {
//        $path = $request->file->store('public');
//        $https = 'https://38339694.qcloud.la/storage/';
//        $ImgUrl = $https . explode("/", $path)[1];
        $cosApi = new Api($this->config());
        $bucket = 'mufengpaobu';
        $dstPath =$request->file;
        $newName=str_random(6).'.'.explode("/", $request->file->getClientMimeType())[1];
        $bizAttr = "/group/".$newName;
        $result = $cosApi->upload($bucket,$dstPath,$bizAttr);

//        $ImgUrl=$result['data']['access_url'];
        $ImgUrl=$this->URL.$bizAttr;
        $Jd=$request->Jd;
        $Wd=$request->Wd;
        $GroupName = $request->GroupName;
        $Introduce = $request->Introduce;
        $PeopleCount = $request->PeopleCount;
        $TotalDistance = $request->TotalDistance;
        $Province = $request->Province;
        $City = $request->City;
        $District = $request->District;
        $DetailedAddr = $request->DetailedAddr;
        $openid = $request->openid;
        $formid = $request->formid;

        if($formid!='the formId is a mock one'){
            DB::table('formid')->insert([
                "openid" =>$openid,
                "formid" =>$formid,
                "State" =>0,
            ]);
        }
        $State = 0;

        $GroupId =DB::table('groups')->insertGetId([
            'GroupName' => $GroupName,
            'Introduce' => $Introduce,
            'Province' => $Province,
            'City' => $City,
            'District' => $District,
            'DetailedAddr' => $DetailedAddr,
            'PeopleCount' => $PeopleCount,
            'TotalDistance' => $TotalDistance,
            'registerDis'=>$TotalDistance,
            'registerCount'=>$PeopleCount,
            'State' => $State,
            'ImgUrl' => $ImgUrl,
            'latitude'=>$Wd,
            'longitude'=>$Jd,
        ]);
        $pinyin = new Pinyin();
        $name=$pinyin->abbr($GroupName);
        $name=strtolower($name);//大写转小写
        $User=$name.rand(0,9).$GroupId;
        $Pass=strtolower(str_random(8));
        $PPass=Crypt::encrypt($Pass);

        DB::table('grouplogin')->insert([
            'User'=>$User,
            'Pass'=>$PPass,
            'GroupId'=>$GroupId
        ]);
        DB::table('usermain')->where('Id',$request->Id)->increment('GroupNum');
        $result=DB::table('MyGroup')->insert([
            'GroupID'=>$GroupId,
            'UserMainID'=>$request->Id,
            'Type'=>1,
            'GroupName'=>$GroupName,
        ]);
        if($result)
            return $GroupId;
//        else return '创建失败';
    }
    //申请入团
    public function applyGroup(Request $request){
        $GroupID=$request->GroupID;
//        $GroupName=$request->GroupName;
        $ID=$request->ID;
        $openid = $request->openid;
        $formid = $request->formid;
        DB::table('formid')->insert([
            "openid" =>$openid,
            "formid" =>$formid,
            "State" =>0,
        ]);
        $GroupName=DB::table('groups')->where('Id',$GroupID)->first()->GroupName;
        $res1=DB::table('groups')->where("Id",$GroupID)->increment('PeopleCount');//数据库中的人数自增1
        $res2=DB::table('usermain')->where("Id",$ID)->increment('GroupNum');
        $res3=DB::table('MyGroup')->insert([
            'GroupID' =>$GroupID,
            'UserMainID'=>$ID,
            'Type'=>3,
            'GroupName'=>$GroupName,
        ]);
        if($res1&&$res2&&$res3) return "true";
        else return "false";
    }
    //上传之前先检测是否频繁提交
    public function checkTime(Request $request){
//        最后要把注释打开
        $Id=$request->Id;
        //管理员可以因为测试需求需要无限次打卡
//        if($Id== 710||$Id==20||$Id==4) return 'true';
        $lastTime=DB::table('run')->where('UserMainID',$Id)->orderBy('Id', 'desc')->first();
        if($lastTime){
            if((time()-strtotime($lastTime->Date))>=60*60*3)
                return 'true';
            else{
                $time=date('H:i',strtotime($lastTime->Date)+60*60*3);
                return $time;
            }
        }
        return 'true';
    }
    public function getGroupPeo(Request $request){//获取所有申请人的信息
        $groupId=$request->GroupID;
        $peo=DB::table('MyGroup')->where([
            'GroupID'=>$groupId,
            'Type'=>0
        ])->select('UserMainID')->get();

        foreach($peo as $item){
            $peo1=DB::table('usermain')->where('Id',$item->UserMainID)->first();
            foreach($peo1 as $key=>$value){
                $item->$key=$value;
            }
            $item->style='';
            $Id=$item->Id;
            $time=date('Y-m-d',time()-30*24*60*60);
            $item->MonthDis=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Id)->whereDate('Date','>',$time)->sum('Distance');
            $item->MonthDis=round($item->MonthDis,2);
        }
        return $peo;
    }
    public function remove(Request $request){
        $id=$request->id;
        $GroupId=$request->GroupID;
        $res=DB::table('MyGroup')->where([
            'UserMainID'=>$id,
            'GroupID'=>$GroupId,
            'Type'=>0
        ])->delete();
        DB::table('groups')->where("Id",$GroupId)->decrement('PeopleCount');
        DB::table('usermain')->where('Id',$id)->decrement('GroupNum');
        return $res?'true':'false';
    }
    //打卡上传跑步信息
    public function uploading(Request $request){
//        return $request->file->getFileName();// 缓存在tmp文件夹中的文件名 例如 php8933.tmp 这种类型的.
        /*
        echo '文件原名:'.$request->file->getClientOriginalName(); // 文件原名:tmp_2125444441o6zAJs85xqiMpdtuJ0MoE_8JW6W04eb0021af34cd4ce1e18ad45b4992d92.jpg
        echo '扩展名'.$request->file->getClientOriginalExtension();   // 扩展名:jpg
        echo '临时文件的绝对路径'.$request->file->getRealPath();  //临时文件的绝对路径:/tmp/phpRQnbl3
        echo 'image/jpeg'.$request->file->getClientMimeType();   // image/jpeg
        return '';*/
//        $path = $request->file->store('public/run');
//        $https = 'https://38339694.qcloud.la/storage/';
//        $ImgUrl = $https . explode("/", $path)[1].'/'. explode("/", $path)[2];

        $cosApi = new Api($this->config());
        $bucket = 'mufengpaobu';
        $dstPath =$request->file;
        $newName=str_random(6).'.'.explode("/", $request->file->getClientMimeType())[1];
        $bizAttr = "/run/".$newName;
        $result = $cosApi->upload($bucket,$dstPath,$bizAttr);
//        $ImgUrl=$result['data']['access_url'];
        $ImgUrl=$this->URL.$bizAttr;
        $TimeLong=$request->TimeLong;
        $Distance=$request->Distance;
        $GroupID=$request->GroupID;
        $Id=$request->Id;//个人id
        $Point=$request->Point;
//        echo "-------------";
        $RunId=0;
        $GroupID=json_decode($GroupID,true);

        if(count($GroupID)){//同步
              for($i=0;$i<count($GroupID);$i++){
                      $GroupI=$GroupID[$i];
                  $myrun=DB::table('run')->whereDate('Date',date('y-m-d',time()))->where('UserMainID',$Id)->where('GroupID',$GroupID[$i])->first();
                  //更新跑团总跑量
                  DB::table('groups')->where('Id',$GroupID[$i])->increment('TotalDistance',$Distance);
                  if($myrun){//已存在，说明当日已经打过一次卡了
                      //今日总跑量、时间累加
                      DB::table('run')->whereDate('Date',date('y-m-d',time()))->where('GroupID',$GroupID[$i])->where('UserMainID',$Id)->where('TotalDis','>',0)->increment('TotalDis', $Distance);
                      DB::table('run')->whereDate('Date',date('y-m-d',time()))->where('GroupID',$GroupID[$i])->where('UserMainID',$Id)->where('TotalTimeLong','>',0)->increment('TotalTimeLong', $TimeLong);
                      $RunId=DB::table('run')->insertGetId([
                          'ImgUrl'=>$ImgUrl,
                          'TimeLong' => $TimeLong,
                          'Distance' => $Distance,
                          'GroupID' => $GroupI,
                          'UserMainID' => $Id,
                          'Point' => $Point,
                          'disRepeat'=>$i
                      ]);
                  }else{//没找到，说明今天是第一次打卡
                      $RunId=DB::table('run')->insertGetId([
                          'ImgUrl'=>$ImgUrl,
                          'TimeLong' => $TimeLong,
                          'TotalTimeLong' => $TimeLong,//第一次打卡，需要把跑步时长存入总时间里面
                          'Distance' => $Distance,
                          'TotalDis' => $Distance,//第一次打卡，需要把跑量存入总跑量里面
                          'GroupID' => $GroupID[$i],
                          'UserMainID' => $Id,
                          'Point' => $Point,
                          'disRepeat'=>$i
                      ]);
                  }
              }

        }else{//不同步
            $RunId=DB::table('run')->insertGetId([
                'ImgUrl'=>$ImgUrl,
                'TimeLong' => $TimeLong,
                'Distance' => $Distance,
                'UserMainID' => $Id,
                'Point' => $Point,
            ]);
        }
        //不管是不是同步至跑团，都需要在用户主表里进行更新用户的总跑量和总积分
        DB::table('usermain')->where('Id',$Id)->increment('TotalRun', $Distance);
        DB::table('usermain')->where('Id',$Id)->increment('TotalPoints', $Point);
        return $ImgUrl;
    }
    //打卡成功后查新跑步历史
    public function upSuccess(Request $request){
//        $flag=$request->Flag;//是否同步至跑团

        $Id=$request->Id;//从小程序获取用户ID
//        $GroupId=$request->GroupId;//获取用户所属跑团id
//        DB::table('usermain')->where('GroupID',7)->orderBy('TotalRun','desc')->update('Rank',1);
        $usermain=DB::table('usermain')->where('Id',$Id)->first();//从数据库把ID用户的所有信息找出来
        $TotalRun=$usermain->TotalRun;//拿出ID的总跑量
        $TotalPoints=$usermain->TotalPoints;//拿出ID的总积分
        $TimeAll=DB::table('run')->where('UserMainID',$Id)->where('disRepeat',0)->count();//ID总打卡次数
        $AdvImg=DB::table('advertise')->where('Id',1)->select('AdvTitle','AdvQRUrl')->first();
//        if($flag=='false'){
//            return ['TotalRun'=>$TotalRun,'TotalPoints'=>$TotalPoints,'TimeAll'=>$TimeAll];//总跑量,总积分，总打卡次数
            return [
                'TotalRun'=>round($TotalRun,2),//拿出ID的总跑量,//总跑量
                'TotalPoints'=>$TotalPoints,//总积分
                'TimeAll'=>$TimeAll,//总打卡次数
//                'LastRank'=>'',//上次团内排名
//                'ThisRank'=>'',//本次团内排名
//                'TimeInGroup'=>'',//在团内打卡总次数
                'Adv'=>$AdvImg//广告
            ];
//        }
//        else if($flag=='true'){
//            $LastRank=$usermain->Rank;//拿出ID的上一次团内跑步排名
//            $ThisRank=DB::table('usermain')->where('GroupID',$GroupId)->where('TotalRun','>',$TotalRun)->count();
//            $ThisRank+=1;//计算本次跑步排名
//            DB::table('usermain')->where('Id',$Id)->update([
//                'Rank'=>$ThisRank,//用本次排名覆盖掉上次排名
//            ]);
//            $TimeInGroup=DB::table('run')->where('UserMainID',$Id)->where('GroupID',$GroupId)->count();//ID在GroupID团内总打卡次数
//
//            return [
//                'TotalRun'=>round($TotalRun,2),//总跑量
//                'TotalPoints'=>$TotalPoints,//总积分
//                'TimeAll'=>$TimeAll,//总打卡次数
//                'LastRank'=>$LastRank,//上次团内排名
//                'ThisRank'=>$ThisRank,//本次团内排名
//                'TimeInGroup'=>$TimeInGroup,//在团内打卡总次数
//                'Adv'=>$AdvImg//广告
//            ];
//        }
    }
    //跑团数据分析
    public function GroupAnalyse(Request $request){
        $run=array();//总的数组
        $weekTime=array();//存每周周天到周六的起始日期
        $weekRun=array();//以周为容器存
        $monthTime=array();//存年月
        $monthRun=array();//以月为容器存
        $yearTime=array();//存年
        $yearSum=array();//存年总跑量
        $yearRun=array();//以年为单位存月总跑量
        $weekSum=array();//存周总跑量
        $monthSum=array();//存月总跑量
        //获取跑团ID
        $GroupID=$request->GroupId;
        $GroupID=(int)$GroupID;
        //获取建团精确时间
        $getGreatTime=DB::table('groups')->where('Id',$GroupID)->first()->CreateDate;
        $getGreatTime=strtotime(date('y-m-d',strtotime($getGreatTime)));//获取建团当天零点的时间戳
        /*周跑量统计
         * */
        $createWeek=date('w',$getGreatTime);//获取建团时间为星期几
        $Sunday=$getGreatTime-24*60*60*$createWeek;//算出建团时间所在周的周天零点的时间戳
        $Saturday=$getGreatTime+24*60*60*(6-$createWeek);//算出建团时间所在周的周六零点的时间戳

        $weeks=1+floor((time()-$Sunday)/(60*60*24*7));//获取从建团到现在一共几周
        $days=$weeks*7;//从建团到现在一共几天（需要显示在页面上的天数）
//        echo date('Y-m-d ',$Sunday);
//        echo $days;
        for($i=0;$i<$weeks;$i++){
            $weekBegin=$Sunday+60*60*24*7*$i;
            $weekEnd=$Saturday+60*60*24*7*$i;
//            $Beginy=date('y',$weekBegin);//年不要了
            $Begin=date('m月d日',$weekBegin);
            $End=date('m月d日',$weekEnd);
            /*周总跑量块开始*/
            $thisBegin=date('y-m-d',$weekBegin);
            $nextBegin=date('y-m-d',$weekBegin+60*60*24*7);
            $thisWeekRun=DB::table('run')->where('GroupID',$GroupID)->whereDate('Date','>=',$thisBegin)->whereDate('Date','<',$nextBegin)->sum('Distance');
            $thisWeekRun=round($thisWeekRun ,2);
            array_push($weekSum,$thisWeekRun);
            /*周总跑量块结束*/

            $week=array();
            array_push($week,$Begin);
            array_push($week,$End);
            array_push($weekTime,$week);
        }
        array_push($run,$weekTime);//把每周的时间打入$rum数组
//        dump($run);
        $thisRun=array();
        for($i=0;$i<$days;$i++){
            $thisTime=date('y-m-d',$Sunday+60*60*24*$i);
            $SumRun=DB::table('run')->whereDate('Date',$thisTime)->where('GroupID',$GroupID)->sum('Distance');
            array_push($thisRun,$SumRun);
            if(($i+1)%7==0){
                array_push($weekRun,$thisRun);
                $thisRun=array();
            }
        }
        array_push($run,$weekRun);//把每天的跑量以周为单位划分打入$rum数组
        /*月跑量统计
         * */
        for($i=$getGreatTime;$i<time();$i+=60*60*24*32){
            $i=strtotime(date('Y-m',$i));//获得本月月初零点时间戳
            $next=strtotime(date('Y-m',$i+60*60*24*32));//获得下月月初零点时间戳

            /*this月总跑量块开始*/
            $thisMonthRun=DB::table('run')->where('GroupID',$GroupID)->whereDate('Date','>=',date('y-m-d',$i))->whereDate('Date','<',date('y-m-d',$next))->sum('Distance');
            $thisMonthRun=round($thisMonthRun ,2);
            array_push($monthSum,$thisMonthRun);
            /*this月总跑量块结束*/

            $days=($next-$i)/(60*60*24);//算出本月有多少天
            array_push($monthTime,date('Y年m月',$i));
//            array_push($monthTime,$days);
            $thisRun=array();
            for($j=0;$j<$days;$j++){
                $thisTime=date('y-m-d',$i+60*60*24*$j);
                $SumRun=DB::table('run')->whereDate('Date',$thisTime)->where('GroupID',$GroupID)->sum('Distance');
                array_push($thisRun,$SumRun);
            }
            array_push($monthRun,$thisRun);
        }
        array_push($run,$monthTime);
        array_push($run,$monthRun);

        /*年跑量统计
         * */
        $beginYear=(int)date('Y',$getGreatTime);
        $thisYear=(int)date('Y',time());
        for($i=$beginYear;$i<=$thisYear;$i++){

            array_push($yearTime,$i);//把当前年份存入数组$yearTime

            $SumRun=DB::table('run')->whereYear('Date',$i)->where('GroupID',$GroupID)->sum('Distance');
            $SumRun=round($SumRun ,2);
            array_push($yearSum,$SumRun);//把当前年份总跑量存入$thisSum
            $thisRun=array();
            for($j=1;$j<=12;$j++){
                $SumRun=DB::table('run')->whereYear('Date',$i)->whereMonth('Date',$j)->where('GroupID',$GroupID)->sum('Distance');
                $SumRun=round($SumRun ,1);
                array_push($thisRun,$SumRun);//把当前年份每个月总跑量存入$thisRun
            }
            array_push($yearRun,$thisRun);
        }
        array_push($run,$yearTime);
        array_push($run,$yearSum);
        array_push($run,$yearRun);
        array_push($run,$weekSum);
        array_push($run,$monthSum);
        return $run;
    }
    //获取用户当天打卡状态
    public function getMyUploadFlag(Request $request){
        $Id=$request->Id;
        $flag=DB::table('run')->where('UserMainID',$Id)->whereDate('Date',date('Y-m-d',time()))->get()->count();
        return $flag;
    }
    //获取个人跑步统计信息
    public function MyAnalyse(Request $request){
        $run=array();//总的数组
        $weekTime=array();//存每周周天到周六的起始日期☆
        $weekRun=array();//以周为容器存
        $monthTime=array();//存年月☆
        $monthRun=array();//以月为容器存
        $yearTime=array();//存年
        $yearRun=array();//以年为单位存月总跑量
        $yearSum=array();//存年总跑量
        $weekSum=array();//存周总跑量
        $monthSum=array();//存月总跑量
        //获取我的ID
        $ID=$request->Id;
        $ID=(int)$ID;
        //获取加入小程序的精确时间
        $RegisterDate=DB::table('usermain')->where('Id',$ID)->first()->RegisterDate;
        $RegisterDate=strtotime(date('y-m-d',strtotime($RegisterDate)));//获取加入小程序当天零点的时间戳
        /*周跑量统计
         * */
        $RegisterWeek=date('w',$RegisterDate);//获取建团时间为星期几
        $Sunday=$RegisterDate-24*60*60*$RegisterWeek;//算出建团时间所在周的周天零点的时间戳
        $Saturday=$RegisterDate+24*60*60*(6-$RegisterWeek);//算出建团时间所在周的周六零点的时间戳

        $weeks=1+floor((time()-$Sunday)/(60*60*24*7));//获取从建团到现在一共几周
        $days=$weeks*7;//从建团到现在一共几天（需要显示在页面上的天数）
//        echo date('Y-m-d ',$Sunday);
//        echo $days;
        for($i=0;$i<$weeks;$i++){
            $weekBegin=$Sunday+60*60*24*7*$i;
            $weekEnd=$Saturday+60*60*24*7*$i;
//            $Beginy=date('y',$weekBegin);//年不要了
            $Begin=date('m月d日',$weekBegin);
            $End=date('m月d日',$weekEnd);
            /*周总跑量块开始*/
            $thisBegin=date('y-m-d',$weekBegin);
            $nextBegin=date('y-m-d',$weekBegin+60*60*24*7);
            $thisWeekRun=DB::table('run')->where('disRepeat',0)->where('UserMainID',$ID)->whereDate('Date','>=',$thisBegin)->whereDate('Date','<',$nextBegin)->sum('Distance');
            $thisWeekRun=round($thisWeekRun ,1);
            array_push($weekSum,$thisWeekRun);
            /*周总跑量块结束*/
            $week=array();
            array_push($week,$Begin);
            array_push($week,$End);
            array_push($weekTime,$week);
        }
        array_push($run,$weekTime);//把每周的时间打入$rum数组
//        dump($run);
        $thisRun=array();
        for($i=0;$i<$days;$i++){
            $thisTime=date('y-m-d',$Sunday+60*60*24*$i);
            $SumRun=DB::table('run')->where('disRepeat',0)->whereDate('Date',$thisTime)->where('UserMainID',$ID)->sum('Distance');
            $SumRun=round($SumRun ,1);
            array_push($thisRun,$SumRun);
            if(($i+1)%7==0){
                array_push($weekRun,$thisRun);
                $thisRun=array();
            }
        }
        array_push($run,$weekRun);//把每天的跑量以周为单位划分打入$rum数组
        /*月跑量统计
         * */
        for($i=$RegisterDate;$i<time();$i+=60*60*24*32){
            $i=strtotime(date('Y-m',$i));//获得本月月初零点时间戳
            $next=strtotime(date('Y-m',$i+60*60*24*32));//获得下月月初零点时间戳

            /*this月总跑量块开始*/
            $thisMonthRun=DB::table('run')->where('disRepeat',0)->where('UserMainID',$ID)->whereDate('Date','>=',date('y-m-d',$i))->whereDate('Date','<',date('y-m-d',$next))->sum('Distance');
            $thisMonthRun=round($thisMonthRun ,1);
            array_push($monthSum,$thisMonthRun);
            /*this月总跑量块结束*/

            $days=($next-$i)/(60*60*24);//算出本月有多少天
            array_push($monthTime,date('Y年m月',$i));
//            array_push($monthTime,$days);
            $thisRun=array();
            for($j=0;$j<$days;$j++){
                $thisTime=date('y-m-d',$i+60*60*24*$j);
                $SumRun=DB::table('run')->where('disRepeat',0)->whereDate('Date',$thisTime)->where('UserMainID',$ID)->sum('Distance');
                $SumRun=round($SumRun ,1);
                array_push($thisRun,$SumRun);
            }
            array_push($monthRun,$thisRun);
        }
        array_push($run,$monthTime);
        array_push($run,$monthRun);

        /*年跑量统计
         * */
        $beginYear=(int)date('Y',$RegisterDate);
        $thisYear=(int)date('Y',time());
        for($i=$beginYear;$i<=$thisYear;$i++){

            array_push($yearTime,$i);//把当前年份存入数组$yearTime

            $SumRun=DB::table('run')->where('disRepeat',0)->whereYear('Date',$i)->where('UserMainID',$ID)->sum('Distance');
            $SumRun=round($SumRun ,1);
            array_push($yearSum,$SumRun);//把当前年份总跑量存入$thisSum
            $thisRun=array();
            for($j=1;$j<=12;$j++){
                $SumRun=DB::table('run')->where('disRepeat',0)->whereYear('Date',$i)->whereMonth('Date',$j)->where('UserMainID',$ID)->sum('Distance');
                $SumRun=round($SumRun ,1);
                array_push($thisRun,$SumRun);//把当前年份每个月总跑量存入$thisRun
            }
            array_push($yearRun,$thisRun);
        }
        array_push($run,$yearTime);
        array_push($run,$yearSum);
        array_push($run,$yearRun);
        array_push($run,$weekSum);
        array_push($run,$monthSum);
        return $run;
    }
    //获取我的跑步记录列表
    public function getMyRunList(Request $request){
        $Id=$request->Id;
        $runlist=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Id)->orderBy('Id', 'desc')->select('Id','Distance','Date')->get();
        foreach($runlist as $item){
            $item->originalDate= $item->Date;
            $item->Date=date('Y年m月d日',strtotime($item->Date));
        }
        return $runlist;
    }
    //删除某条跑步记录
    public function RemoveRun(Request $request){
        $Id=$request->Id;
        $originalDate=$request->originalDate;
        $time=date('Y-m-d H',strtotime($originalDate));
        $day=date('Y-m-d',strtotime($originalDate));
//        echo $time;
        $Distance=$request->Distance;
//        $GroupNum=DB::table('usermain')->where('Id',$Id)->first()->GroupNum;
        $GroupNum=10;//当有一天，开放跑团数量大于10，需要改
        $res1=false;

        for($i=0;$i<$GroupNum;$i++){
            $GroupId=DB::table('run')->where([
                'UserMainID'=>$Id,
                'Distance'=>$Distance,
                'disRepeat'=>$i,
            ]) ->where('Date','like',$time.'%')->first();
            if($GroupId){//如果在这个团里打卡
                $GroupID=$GroupId->GroupID;
                $timeLong=$GroupId->TimeLong;
                $res4=DB::table('run')->where([
                    'UserMainID'=>$Id,
                    'GroupID'=>$GroupID,
                ])->where('TotalDis','>',0)->whereDate('Date',$day)->decrement('TotalDis',$Distance);
//                echo '$res4:'.$res4;
                $res5=DB::table('run')->where([
                    'UserMainID'=>$Id,
                    'GroupID'=>$GroupID,
                ])->where('TotalTimeLong','>',0)->whereDate('Date',$day)->decrement('TotalTimeLong',$timeLong);
//                echo '跑步时间:'.$timeLong;
//                echo '$res5:'.$res5;
                $res3=DB::table('run')->where([
                    'UserMainID'=>$Id,
                    'Distance'=>$Distance,
                    'GroupID'=>$GroupID,
                ])->where('Date','like',$time.'%')->delete();
//                echo '$res3:'.$res3;
                if($res3&&$res4&&$res5){
                    $res1=true;
                    DB::table('groups')->where('Id',$GroupID)->decrement('TotalDistance',$Distance);
                }
            }
        }
        $res2=DB::table('run')->where([
            'UserMainID'=>$Id,
            'Distance'=>$Distance,
            'GroupID'=>0,
            'disRepeat'=>0,
        ])->where('Date','like',$time.'%')->delete();

        $res4=DB::table('usermain')->where('Id',$Id)->decrement('TotalRun',$Distance);
        if($res4) return 'true';
        return 'false';
    }
    //获取历史某次跑步详情
    public function runDetail(Request $request){
        $Id=$request->Id;
        $thisDate=DB::table('run')->where('disRepeat',0)->where('Id',$Id)->first()->Date;
        $Run=DB::table('run')->where('disRepeat',0)->where('Id',$Id)->first();
        $Run->NickName=DB::table('usermain')->where('Id',$Run->UserMainID)->first()->NickName;
        $Run->TimeLong=(int)$Run->TimeLong;
        $Run->hour=floor($Run->TimeLong/3600);
        $Run->minute=round(($Run->TimeLong%3600)/60);
        $Run->second=$Run->TimeLong%3600%60;
        $Run->TotalRun=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Run->UserMainID)->where('Date','<=',$thisDate)->sum('Distance');
        $Run->TotalRun=round($Run->TotalRun ,1);
        $Run->TimeAll=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Run->UserMainID)->where('Date','<=',$thisDate)->count();
        $Run->TotalPoints=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Run->UserMainID)->where('Date','<=',$thisDate)->sum('Point');
        $AdvImg=DB::table('advertise')->where('Id',1)->select('AdvTitle','AdvQRUrl')->first();
        return [$Run,$AdvImg];
    }
    //查看排名个人跑步图片
    public function getRunImg(Request $request){
        $Id=$request->Id;
        $GroupId=$request->GroupId;
        $Img=DB::table('run')->whereDate('Date',date('y-m-d',time()))->where([
            'UserMainID'=>$Id,
            'GroupID'=>$GroupId,
        ])->select('Id','ImgUrl','Distance','TimeLong')->get();
        foreach($Img as $k => $v){
            $v->Hour=floor($v->TimeLong/3600);
            $v->Minute=round(($v->TimeLong%3600)/60);
        }
        return $Img;
    }
    //查找
    public function find(Request $request){
        $key=$request->key;
        $key=preg_split('/(?<!^)(?!$)/u', $key);
        switch(count($key)){
            case 1: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%')->get();break;
            case 2: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%')->get();break;
            case 3: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%'.$key[2].'%')->get();break;
            case 4: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%'.$key[2].'%'.$key[3].'%')->get();break;
            case 5: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%'.$key[2].'%'.$key[3].'%'.$key[4].'%')->get();break;
            case 6: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%'.$key[2].'%'.$key[3].'%'.$key[4].'%'.$key[5].'%')->get();break;
            case 7: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%'.$key[2].'%'.$key[3].'%'.$key[4].'%'.$key[5].'%'.$key[6].'%')->get();break;
            case 8: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%'.$key[2].'%'.$key[3].'%'.$key[4].'%'.$key[5].'%'.$key[6].'%'.$key[7].'%')->get();break;
            case 9: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%'.$key[2].'%'.$key[3].'%'.$key[4].'%'.$key[5].'%'.$key[6].'%'.$key[7].'%'.$key[8].'%')->get();break;
            case 10: $result=DB::table('groups')->where('State',1)->where('GroupName','like','%'.$key[0].'%'.$key[1].'%'.$key[2].'%'.$key[3].'%'.$key[4].'%'.$key[5].'%'.$key[6].'%'.$key[7].'%'.$key[8].'%'.$key[9].'%')->get();break;
        }
        return $result;
    }
    //举报
    public function Report(Request $request){
//        $Id=$request->Id;
//        $UserMainID=DB::table('run')->where('Id',$Id)->first()->UserMainID;
//        if(DB::table('run')->where('Id',$Id)->first()->Report==0){
//            DB::table('usermain')->where('Id',$UserMainID)->increment('ReportNum');//个人主表记录自增
//        }
//        DB::table('run')->where('Id',$Id)->increment('Report');//跑量举报记录自增
    }
    //获取举报信息
    public function getReport(Request $request){
//        $GroupID=$request->GroupID;
//        $Reported=DB::table('usermain')->where('GroupID',$GroupID)->where('ReportNum',5)->select('Id','HeadImgUrl','NickName')->get();
//        foreach($Reported as $key => $value){
//            $value->Run=DB::table('run')->where([
//                ['UserMainID',$value->Id],
//                ['GroupID',$GroupID],
//                ['Report','>',0]
//            ])->select('Id','ImgUrl','Distance','TimeLong')->get();
//            foreach($value->Run as $k =>$v){
//                $v->Hour=floor($v->TimeLong/3600);
//                $v->Minute=round(($v->TimeLong%3600)/60);
//            }
//        }
//        return $Reported;
    }
    //清除跑步记录积分
    public function clearPoint(Request $request){

    }
    //
    public function ignore(){

    }
    //退出跑团
    public function quitGroup(Request $request){
        $Id=$request->Id;
        $GroupId=$request->GroupId;
        //我加入的跑团数量减一
        $res1=DB::table('usermain')->where('Id',$Id)->where('GroupNum','>',0)->decrement('GroupNum');
        //跑团人数减一
        $res2=DB::table('groups')->where('Id',$GroupId)->where('PeopleCount','>',0)->decrement('PeopleCount');
        //解除我和跑团的关系
        $res3=DB::table('MyGroup')->where([
            'GroupID'=>$GroupId,
            'UserMainID'=>$Id,
            'Type'=>0,
        ])->delete();
        //我的跑步记录不再在跑团显示
        $res4=DB::table('run')->where([
            'GroupID'=>$GroupId,
            'UserMainID'=>$Id
        ])->update([
            'GroupID'=>0,
        ]);
        if($res1&&$res2&&$res3&&$res4) return 'true';
        else return 'false';
    }
    //团长获取电脑端登录信息
    public function getAccount(Request $request){
        $GroupId=$request->GroupId;
        $account=DB::table('grouplogin')->where("GroupId",$GroupId)->first();
        $Pass=Crypt::decrypt($account->Pass);

        if($account){
            return [$account->User,$Pass];
        }else{
            return 'false';
        }
    }
    //修改团信息
    public function changeGroupInfo(Request $request){
        $groupId=$request->GroupID;
        $Introduce = $request->Content;
        if($request->ImgChange){//如果图片修改了
            $imgUrl=DB::table('groups')->where('Id',$groupId)->first()->ImgUrl;
            $bucket = 'mufengpaobu';
            $imgUrl=explode('mufengpaobu.com',$imgUrl)[1];
            $cosApi = new Api($this->config());
            $result1 = $cosApi->delFile($bucket, $imgUrl);
            //存进去新的图片
            $dstPath =$request->upInfo;
            $newName=str_random(6).'.'.explode("/", $request->upInfo->getClientMimeType())[1];
            $bizAttr = "/group/".$newName;
            $result2 = $cosApi->upload($bucket,$dstPath,$bizAttr);
//            $ImgUrl=$result2['data']['access_url'];
            $ImgUrl=$this->URL.$bizAttr;
            $result3=DB::table('groups')->where('Id',$groupId)->update([
                'ImgUrl'=>$ImgUrl,
                'Introduce'=>$Introduce
            ]);
            if($result1['code']==0&&$result2['code']==0&&$result3==1) return "1";
            else return '0';
        }else{//图片未修改
            $result=DB::table('groups')->where('Id',$groupId)->update([
                'Introduce'=>$Introduce
            ]);
            return $result;
        }
    }

    public function agree(Request $request){
        $id=$request->id;
        $groupId=$request->GroupID;
        DB::table('MyGroup')->where([
            'UserMainID'=>$id,
            'GroupID'=>$groupId
        ])->update(['Type'=>0]);
        $peo=DB::table('usermain')->where('Id',$id)->first();
        /*
         * 张迪，团长同意进群并发送模板消息
         * */
        $openid=DB::table('usermain')->where('Id',$id)->first()->openid;
        $form=DB::table('formid')->where([
            'State'=>0,
            'openid'=>$openid
        ])->first();
        if($form){//如果找到了formid,说明可以发送模板消息

            $templateid='lCYJEHTxm9vijAXyYp59awXASqiN_tzbW5ER4bkCwzM';
            $formid=$form->formid;

            $Id=$form->Id;
            $GroupName=$peo->GroupName;

            $data_arr = array(
                'keyword1' => array( "value" => '您的审核已通过',"color" => '#ccc' ),
                'keyword2' => array( "value" =>$GroupName,"color" => '#ccc' ),
            );
            echo '模板消息：'.$data_arr['keyword2']['value'];
//			echo 'BUG现身大法:$formid'.$formid.'<br>';
//			echo 'BUG现身大法:$openid'.$openid.'<br>';
//			echo 'BUG现身大法:$templateid'.$templateid.'<br>';
//			echo 'BUG现身大法:$data_arr'.$data_arr['keyword2']['value'].'<br>';
            $result=$this->sendTemplate($openid,$formid,$templateid,$data_arr);
            DB::table('formid')->where('Id', $Id)->delete();
            return $result;
        }
//		DB::table('formid')->whereDate('whereDate','<',date('y-m-d h:i:s',time()-7*24*60*60))->delete();

    }
    public function noAgree(Request $request){
        $id=$request->id;
        $GroupId=$request->GroupId;
        $peo=DB::table('usermain')->where('Id',$id)->first();
        DB::table('MyGroup')->where([
            'UserMainID'=>$id,
            'GroupID'=>$GroupId,
            'Type'=>3,
        ])->delete();
        DB::table('usermain')->where("Id",$id)->where('GroupNum','>',0)->decrement('GroupNum');
        DB::table('groups')->where("Id",$GroupId)->where('PeopleCount','>',0)->decrement('PeopleCount');
//        echo 'BUG现身大法';
//
//        echo '跑团名：'.$peo->GroupName;
        //发送模板消息
        /*张迪，团长拒绝进群并给该用户发送模板消息
         * */
        $openid=DB::table('usermain')->where('Id',$id)->first()->openid;
//		DB::table('formid')->where('formid','the formId is a mock one')->delete();
        $form=DB::table('formid')->where([
            'State'=>0,
            'openid'=>$openid
        ])->first();

        if($form){//如果找到了formid,说明可以发送模板消息
            $templateid='lCYJEHTxm9vijAXyYp59awXASqiN_tzbW5ER4bkCwzM';
            $formid=$form->formid;
            $Id=$form->Id;
            $GroupName=$peo->GroupName;
            echo 'BUG现身大法1111111111:';
            echo '跑团名：'.$GroupName;
            $data_arr = array(
                'keyword1' => array( "value" => '入团审核未通过', "color" => '#ccc' ),
                'keyword2' => array( "value" =>$GroupName, "color" => '#ccc' ),
            );
            $result=$this->sendTemplate($openid,$formid,$templateid,$data_arr);
            DB::table('formid')->where('Id', $Id)->delete();
            return $result;
        }

    }
    function send_post( $url, $post_data ) {//张迪：发送pose请求
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
    function sendTemplate($openid,$formid,$templateid,$data_arr){//张迪：发送模板消息
        $appid="wxa2a449343b9263dd";
        $appsecret="ed0e07b2580bb7df72d8ea3bf7ef1e68";
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $html = file_get_contents($url);
        $output = json_decode($html, true);
        $access_token = $output['access_token'];
//		$openid="oURrw0G-31MzIZ26T4WVsCkmrOm4";
//		$formid="1503116041807";
//		$templateid="4Udyzyn6nrQ83ms_Zq8euo6ATkAStq3TyNJtwTX0XTE";
//		$data_arr = array(
//				'keyword1' => array( "value" => 'ahaha', "color" => '#ccc' ),
//				'keyword2' => array( "value" => '123454465', "color" => '#ccc' ),
//		);
        $post_data = array (
            "touser"           => $openid,
            //用户的 openID，可用过 wx.getUserInfo 获取
            "template_id"      => $templateid,
            //小程序后台申请到的模板编号
//            "page"             => "/pages/check/result?orderID=".$orderID,
            //点击模板消息后跳转到的页面，可以传递参数
            "form_id"          => $formid,
            //第一步里获取到的 formID
            "data"             => $data_arr,
            "emphasis_keyword" => "keyword2.DATA"
            //需要强调的关键字，会加大居中显示
        );
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token;
        $data = json_encode($post_data, true);
        $return = $this->send_post( $url, $data);
        echo $return;
    }
    public function test(Request $request){
        echo '带着希望去旅行，比到达终点更美好';
    }
    public function ceshi(){//测试用的

        $Id=708;
        $thisDate=DB::table('run')->where('UserMainID',$Id)->first()->Date;
        echo $thisDate;
        $Run=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Id)->first();
        dd($Run);
        $Run->TotalRun=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Run->UserMainID)->where('Date','<=',$thisDate->Date)->sum('Distance');
        $Run->TotalRun=round($Run->TotalRun ,1);
        $Run->TimeAll=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Run->UserMainID)->where('Date','<=',$thisDate)->count();
        $Run->TotalPoints=DB::table('run')->where('disRepeat',0)->where('UserMainID',$Run->UserMainID)->where('Date','<=',$thisDate)->sum('Point');

////        $MyTime=DB::table('run','usermain')->where('run.disRepeat',0)->where('run.UserMainID',708)->select("run.Distance")->get();
////        $MyTime=DB::table('usermain','run')->select("usermain.Id","usermain.TotalRun")->where("run.")->get();
//        $run=DB::table('usermain')->select('Id','TotalRun')->whereNotNull('NickName')->get();
//        foreach($run as $item){
//            $item->yunsuanRun=DB::table('run')->where('disRepeat',0)->where('UserMainID',$item->Id)->get()->sum('Distance');
//            DB::table('usermain')->where("Id",$item->Id)->update([
//                'TotalPoints' =>$item->yunsuanRun*10
//            ]);
//            if($item->TotalRun!=$item->yunsuanRun){
//                echo $item->Id."    ";
//                echo "跑量：".$item->TotalRun."    ";
//                echo "运算".$item->yunsuanRun;
//                if($item->TotalRun>$item->yunsuanRun) echo "大".($item->TotalRun-$item->yunsuanRun);
//                else echo "小".($item->yunsuanRun-$item->TotalRun);
//                echo "<br>";
//                DB::table('usermain')->where("Id",$item->Id)->update([
//                    'TotalRun' =>$item->yunsuanRun
//                ]);
//                echo "_________________________________________"."<br>";
//            }
//        }
//
////        dd($run);
    }
}
