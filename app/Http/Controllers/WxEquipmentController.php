<?php

namespace App\Http\Controllers;
require('org/cos-php-sdk/include.php');
use App\Http\Model\Equipment;
use App\Http\Model\EquipmentImage;
use App\Http\Model\Groups;
use App\Http\Model\MyGroup;
use App\Http\Model\Story;
use App\Http\Model\UserMain;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Qcloud\Cos\Api;

class WxEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $equipment = new Equipment();
        $equipment->name = $request->input('EquipmentName');
        $equipment->introduce = $request->input('EquipmentIntroduce');
        $equipment->price = $request->input('EquipmentPrice');
        $equipment->phone = $request->input('Phone');
        $equipment->brand = $request->input('EquipmentBrand');
        $equipment->groupId  = $request->input('groupId');
        $equipment->UserMainID  = $request->input('UserMainID');
        $equipment->save();
        return ['id'=>$equipment->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $equipment = Equipment::find($id);
        $images = $equipment->images()->get();
        $imgNum = count($images);
        $res = $equipment->toArray();
        $thisImages = [];
        for($i = 0;$i<$imgNum;$i++){
            $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/equipment/" . $images[$i]->url;
            array_push($thisImages,$url);
        }
        array_push($res,$thisImages);
        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $oldEquipment = Equipment::find($id);
        if($oldEquipment){
            $oldEquipment->delete();
        }
        $equipment = new Equipment();
        if($equipment){
            $equipment->name = $request->input('EquipmentName');
            $equipment->introduce = $request->input('EquipmentIntroduce');
            $equipment->price = $request->input('EquipmentPrice');
            $equipment->phone = $request->input('Phone');
            $equipment->brand = $request->input('EquipmentBrand');
            $equipment->groupId  = $request->input('groupId');
            $equipment->UserMainID  = $request->input('UserMainID');
            $equipment->save();
            return ["id"=>$equipment->id];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $equipment = Equipment::find($id);
        if($equipment){
            $equipment->delete();
        }
    }
    public function upImage(Request $request){
        $cosApi = new Api($this->config());
        $bucket = 'mufengpaobu';
        $dstPath =$request->image;
        $newName=str_random(6).'.'.explode("/", $request->image->getClientMimeType())[1];
        $bizAttr = "/equipment/".$newName;
        $result = $cosApi->upload($bucket,$dstPath,$bizAttr);
        $image = new EquipmentImage();
        $image->url = $newName;
        $image->equipmentId = $request->input('id');
        $image->save();
        return [$result];
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
    }
    public function page($page){
        $eachNum = 6;
        $start = ($page-1) * $eachNum;
        $end = $page*$eachNum;
        $temp = Equipment::orderBy("id","desc")->where('state','=','1')->get();
        $sum = count($temp);
        $datas = new Collection();
        for($i = $start;$i<$end&&$i<$sum;$i++){
            $datas->push($temp[$i]);
        }

        $res = $datas->toArray();
        $len = count($datas);
        for($i = 0;$i<$len;$i++){
            $date = strtotime($datas[$i]->created_at);
            if(count($datas[$i]->images()->get())>0) {
                //echo $res[$i]->images()->get()[0];
                //dd($res[$i]->images()->get()[0]->url);
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/equipment/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
            $temp2 = array('time'=>date('Y-m-d',$date));
            $res[$i] = array_merge($res[$i],$temp2);
        }
        return $res;
    }
    function findEquipment(Request $request){
        $name = $request->input('name');
        $datas = Equipment::where('name','like','%'.$name.'%')->get();

        $res = $datas->toArray();
        $len = count($datas);
        for($i = 0;$i<$len;$i++){
            if(count($datas[$i]->images()->get())>0) {
                //echo $res[$i]->images()->get()[0];
                //dd($res[$i]->images()->get()[0]->url);
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/equipment/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
        }
        return $res;
    }

    function equipmentCheck($groupId){
        $res = Equipment::orderBy('id','desc')->where('groupId','=',"$groupId")->where('state','=','0')->get();
        return $res->toArray();
    }
    function checkEquipment(Request $request){
        $equipmentId = $request->input("equipmentId");
        $equipment = Equipment::find($equipmentId);
        if($request->option=='accept'){
            $equipment->state = 1;
            $equipment->save();
        }else{
            $equipment->delete();
        }
    }
    function getNum($groupId,$type){
        $count = 0;
        if($type=='story') {
            $count = count(Story::where('groupId','=',$groupId)->where('state', '=', '0')->get());
        }
        else if($type=='equipment'){
            $count = count(Equipment::where('groupId','=',$groupId)->where('state', '=', '0')->get());
        }
        return ['count'=>$count];
    }
    function myManagerGroup($id){
        $user = UserMain::find($id);
        $groups = $user->groups()->get();
        $myManagerGroup = array();
        for($i = 0;$i<count($groups);$i++){
            $each = MyGroup::where('GroupID','=',$groups[$i]->Id)->where('UserMainID','=',$user->Id)->where('Type','=','1')->get();
            if(count($each)>0){
                array_push($myManagerGroup,$each[0]->GroupID);
            }
        }

        for($i = 0;$i<count($myManagerGroup);$i++){
            $story = Story::where('groupId','=',$myManagerGroup[$i])->where('state','=','0')->get();
            if(count($story)>0){
                return ['state'=>'1'];
            }
        }
        for($i = 0;$i<count($myManagerGroup);$i++){
            $equipment = Equipment::where('groupId','=',$myManagerGroup[$i])->where('state','=','0')->get();
            if(count($equipment)>0){
                return ['state'=>'1'];
            }
        }
        for ($i = 0; $i<count($myManagerGroup);$i++){
            $apply = MyGroup::where('groupId','=',$myManagerGroup[$i])->where('Type','=','3')->get();
            if(count($apply)>0){
                return ['state'=>'1'];
            }
        }
        return ['state'=>'0'];
    }
    function myGroup($id){
        $user = UserMain::find($id);
        $group = $user->groups()->get();
        return $group->toArray();
    }
    function myEquipment($id,$page){
        $eachNum = 6;
        $start = ($page-1) * $eachNum;
        $end = $page*$eachNum;
        $temp = Equipment::orderBy("id","desc")->where('UserMainID','=',$id)->get();
        $sum = count($temp);
        $datas = new Collection();
        for($i = $start;$i<$end&&$i<$sum;$i++){
            $datas->push($temp[$i]);
        }
        $res = $datas->toArray();
        $len = count($datas);
        for($i = 0;$i<$len;$i++){
            $date = strtotime($datas[$i]->created_at);
            if(count($datas[$i]->images()->get())>0) {
                //echo $res[$i]->images()->get()[0];
                //dd($res[$i]->images()->get()[0]->url);
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/equipment/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
            $temp2 = array('time'=>date('Y-m-d',$date));
            $res[$i] = array_merge($res[$i],$temp2);
        }
        return $res;
    }
    //查找我的装备
    function findMyEquipment(Request $request){
        $name = $request->input('name');
        $UserMianID = $request->input('UserMainID');
        $datas = Equipment::where('UserMainID','=',$UserMianID)->where('name','like','%'.$name.'%')->get();
        $res = $datas->toArray();
        $len = count($datas);
        for($i = 0;$i<$len;$i++){
            if(count($datas[$i]->images()->get())>0) {
                //echo $res[$i]->images()->get()[0];
                //dd($res[$i]->images()->get()[0]->url);
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/equipment/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
        }
        return $res;
    }
}
