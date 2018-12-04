<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
require('org/cos-php-sdk/include.php');
use Qcloud\Cos\Api;

class AdvertiseController extends CommonController{

    

    public function index($group_id)
    {
        $data=DB::table('advertise')
            ->where('GroupID',$group_id)
            ->get();
        return view('admin.second.changeadvindex')->with('data',$data);
    }
    public function advother($group_id)
    {
        $data=DB::table('advertise')
            ->where('GroupID',$group_id)
            ->get();
        return view('admin.second.changeadvother')->with('data',$data);
    }
    public function advlook($group_id)
    {
        $data=DB::table('advertise')
            ->where('GroupID',$group_id)
            ->get();
        return view('admin.second.changeadvlook')->with('data',$data);
    }
    public function adv_add(Request $request,$group_id){
        //$input=Input::all();
        $rules=[
            'adv-title'=>'between:0,10',
            'adv-control'=>'between:0,200',
        ];
        $message=[
            'adv-title.between'=>"*标题长度最多10个汉字",
            'adv-control.between'=>"*内容长度最多200个汉字",
        ];
        $validator=Validator::make($request->all(),$rules,$message) ;
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
            $adv=DB::table('advertise')->where('GroupID',$group_id)->value('AdvImgUrl');
            $file_adv = $request->advimg;

            if($file_adv) {
                if($adv){
                    $findImg=explode(".com/", $adv)[1];
                    $cosApi->delFile('mufengpaobu',$findImg );
                }
                $entension = $file_adv->getClientOriginalExtension(); //上传文件的后缀.
                $Name = date('YmdHis') . mt_rand(100, 999) . '.' . $entension;//重命名年月日时分秒+一个随机数
                $newName = "/adv/$Name";
                $bucket = 'mufengpaobu';
                $dstPath = $file_adv;
                $cosApi->upload($bucket, $dstPath, $newName);
//                $result = $cosApi->stat('mufengpaobu',$newName );
//                $adv=$result['data']['access_url'];
                $adv="http://static.mufengpaobu.com$newName";

            }
            //结束
            //检验是否上传二维码
            $QR=DB::table('advertise')->where('GroupID',$group_id)->value('AdvQRUrl');
            $find_QR = $request->advQR;
            if($find_QR) {
                if($QR){
                    $findQR=explode(".com/", $QR)[1];
                    $cosApi->delFile('mufengpaobu', $findQR);
                }
                $entension = $find_QR->getClientOriginalExtension(); //上传文件的后缀.
                $Name = date('YmdHis') . mt_rand(100, 999) . '.' . $entension;//重命名年月日时分秒+一个随机数
                $newName = "/adv/$Name";
                $bucket = 'mufengpaobu';
                $dstPath = $find_QR;
                $cosApi->upload($bucket, $dstPath, $newName);
                $adv="http://static.mufengpaobu.com$newName";
            }
            //结束
            DB::update('update advertise set AdvTitle = ?,Content = ?,AdvImgUrl = ?,AdvQRUrl = ?,ExistDate = ?,UploadDate = ? where GroupID = ?', [$request->input('adv-title'),$request->input('adv-control'),$adv,$QR,$request->input('adv-day'),date('Y-m-d',time()),$group_id]);
            return redirect("admin/group");
        }else{
            return back()->withErrors($validator);
        }
    }
    //通过审核广告位
    public function adv_addother($group_id){
        DB::table('advertise')
            ->where('GroupID',$group_id)
            ->update([
                'UploadDate' => date('Y-m-d', time()),
            ]);
        DB::update('update groups set AdvState = ? where Id = ?', [2, $group_id]);
        return redirect("admin/group");
    }
    //不通过审核
    public function advertisenopass($groupid){
        DB::table('advertise')
            ->where('GroupID', $groupid)
            ->delete();
        $re=DB::update('update groups set AdvState = ?,AdvId = ? where Id = ?', [0,0, $groupid]);
        if($re){
            $data=[
                'msg' => "操作成功，请刷新“跑团管理”页面"
            ];
        }else{
            $data=[
                'msg' => "操作失败请重试"
            ];
        }

        return $data;
    }

}
