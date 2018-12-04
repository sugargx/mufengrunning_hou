<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\Storage;
require('org/cos-php-sdk/include.php');
use Qcloud\Cos\Api;
class WxController_hkf extends Controller
{
	function config(){
		return array(
				'app_id' => '1254050776',
				'secret_id' => 'AKIDMbgX9WuW9XgaEdviOozwd5HEwOcblq67',
				'secret_key' => 'vc3GEwOaWCbkdGdkcx50hANK0QZS4RXN',
				'region' => 'sh',
				'timeout' => 60
		);
	}

    public function getApplicants(Request $request){//获取所有申请人的信息
		$groupId=$request->GroupId;
		$applicants=DB::table('usermain')->where('GroupID',$groupId)->where('Type',3)->get();
		return $applicants;
    }
	public function getGroupPeo(Request $request){//获取所有申请人的信息
		$groupId=$request->GroupID;
		$peo=DB::table('usermain')->where('GroupID',$groupId)->where('Type',0)->get();
		foreach($peo as $item){
			$item->style='';
			$Id=$item->Id;
			$time=date('Y-m-d',time()-30*24*60*60);
			$item->MonthDis=DB::table('run')->where('UserMainID',$Id)->whereDate('Date','>',$time)->sum('Distance');
		}
		return $peo;
	}
	public function agree(Request $request){
		$id=$request->id;
		$type=$request->Status;
		$groupId=$request->GroupID;
		DB::table('usermain')->where('Id',$id)->update(['Type'=>$type],['GroupID'=>$groupId]);
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
		$type=$request->Status;
		DB::table('usermain')->where('Id',$id)->update([
				'Type'=>$type,
				'GroupID'=>0,
				'GroupName'=>null
		]);
		DB::table('groups')->where("Id",$GroupId)->decrement('PeopleCount');
		echo 'BUG现身大法！！！！！！';
		$peo=DB::table('usermain')->where('Id',$id)->first();
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
			$data_arr = array(
					'keyword1' => array( "value" => '入团审核未通过', "color" => '#ccc' ),
					'keyword2' => array( "value" => $GroupName, "color" => '#ccc' ),
			);
			$result=$this->sendTemplate($openid,$formid,$templateid,$data_arr);
			DB::table('formid')->where('Id', $Id)->delete();

		}
		return $peo;	
	}
	public function remove(Request $request){
		$id=$request->id;
		$GroupId=$request->GroupID;
		$type=$request->Status;
		DB::table('usermain')->where('Id',$id)->update([
				'Type'=>$type,
				'GroupID'=>0,
				'GroupName'=>null
		]);
		DB::table('groups')->where("Id",$GroupId)->decrement('PeopleCount');
		$peo=DB::table('usermain')->where('Id',$id)->get();
		return $peo;
	}
	public function getGroupInfo(Request $request){
		$groupId=$request->GroupID;
		$groups=DB::table('groups')->where('Id',$groupId)->get();
		return $groups;
	}

	/*创建广告位
	public function creatAdv1(Request $request){
		$name = $request->Name;
        $content = $request->Content;
		$groupId=$request->GroupID;
		$day=$request->day;
		$day*=3600*24;
		
		$id = DB::table('advertise')->insertGetId([
            'AdvTitle' => $name,
            'Content' => $content,
			'AdvImgUrl'=> "",
			'AdvQRUrl'=> "",
			'GroupID' => $groupId,
			'ExistDate' => $day
        ]);
        if($id) return ['Id'=>$id];
        else return '失败！';
	}
	public function creatAdv2(Request $request){
		$id=$request->id;
		$path = $request->ad->store('public');
        $https = 'https://38339694.qcloud.la/storage/';
        $ImgUrl = $https . explode("/", $path)[1];
		DB::table('advertise')->where('Id',$id)
		->update(['AdvImgUrl'=>$ImgUrl]);
	   return "成功";
	}
	public function creatAdv3(Request $request){
		$id=$request->id;
		$path = $request->ad->store('public');
        $https = 'https://38339694.qcloud.la/storage/';
        $ImgUrl = $https . explode("/", $path)[1];
		DB::table('advertise')->where('Id',$id)
		->update(['AdvQRUrl'=>$ImgUrl]);

	   return "成功";
	}
*/
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
}

?>













