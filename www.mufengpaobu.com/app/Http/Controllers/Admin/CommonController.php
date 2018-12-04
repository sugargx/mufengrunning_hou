<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
require('org/cos-php-sdk/include.php');
use Qcloud\Cos\Api;


class CommonController extends Controller{

    //用户详情页
    public function show_user($id){
        if($id!=0) {
            //折线图
            $begin=DB::table('usermain')->where('Id',$id)->value('RegisterDate');
            $time=strtotime($begin);
            //判断是否是同一年
            $data=array();
            //是同一年
            if(date('Y', $time) == date('Y',time())){
                for($i=(int)date('m', $time); $i <= date('m',time()); $i++) {
                    $num=DB::table('run')
                        ->where('UserMainID',$id)
                        ->where('disRepeat',0)
                        ->whereYear('Date',date('Y',time()))
                        ->whereMonth('Date',$i)
                        ->count();
                    $distance=DB::table('run')
                        ->where('disRepeat',0)
                        ->where('UserMainID',$id)
                        ->whereYear('Date',date('Y',time()))
                        ->whereMonth('Date',$i)
                        ->sum('Distance');
                    $new=[
                        'time'=>"$i 月",
                        'num'=>$num,
                        'distance'=>$distance
                    ];
                    array_push($data,$new);
                }
            }else{
                for($i=1; $i <= date('m',time()); $i++) {
                    $num=DB::table('run')
                        ->where('UserMainID',$id)
                        ->where('disRepeat',0)
                        ->whereYear('Date',date('Y',time()))
                        ->whereMonth('Date',$i)
                        ->count();
                    $distance=DB::table('run')
                        ->where('disRepeat',0)
                        ->where('UserMainID',$id)
                        ->whereYear('Date',date('Y',time()))
                        ->whereMonth('Date',$i)
                        ->sum('Distance');
                    $new=[
                        'time'=>"$i 月",
                        'num'=>$num,
                        'distance'=>$distance
                    ];
                    array_push($data,$new);
                }
            }
            //信息表
            $user_name = DB::table('usermain')
                ->where('Id', $id)
                ->get();
            $user_group = DB::table('MyGroup')
                ->where('UserMainID',$id)
                ->get();
            //打卡表
            $user_day = DB::table('run')
                ->where('UserMainID', $id)
                ->where('disRepeat',0)
                ->orderBy('Date', 'desc')
                ->paginate(10);
            return view('admin.second.userdata')->with(['group_data' => $user_group,'day_data' => $user_day, 'data' => $user_name, 'pic'=>$data]);
        }else{
            return back();
        }
    }
    //跑团详情页
    public function show($groupname){
        if($groupname!=0){
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

            $user=DB::table('MyGroup')
                ->where('GroupID',$groupname)
                ->paginate(10);


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

            return view('admin.second.groupdata')->with([ 'pic_day'=>$data_day,'pic_month'=>$data_month,'group_data'=>$group,'adv_data'=>$advertise,'user_data'=>$user]);
        }else{
            return back();
        }
    }
    //图片上传
//    public function store()
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
//        }
//    }
//没用到
    public function create(){

    }
}
