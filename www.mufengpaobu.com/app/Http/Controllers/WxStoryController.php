<?php

namespace App\Http\Controllers;

use App\Http\Model\Comment;
use App\Http\Model\DaShang;
use App\Http\Model\Reply;
use App\Http\Model\Story;
use App\Http\Model\StoryImage;
use App\Http\Model\UserMain;
use App\Http\Model\ZanLog;
use Illuminate\Http\Request;
require('org/cos-php-sdk/include.php');

use Illuminate\Support\Collection;
use Qcloud\Cos\Api;
class WxStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $story = new Story();
        $story->storyName = $request->input('storyName');
        $story->content = $request->input('content');
        $story->writerName = $request->input('writerName');
        $story->groupId = $request->input('groupId');
        $story->UserMainID = $request->input('UserMainID');
        $story->save();
        return ["id"=>$story->id];
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
        $story = Story::find($id);
        $images = $story->images()->get();
        $imgNum = count($images);
        $res = $story->toArray();
        $thisImages = [];
        for($i = 0;$i<$imgNum;$i++){
            $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/story/" . $images[$i]->url;
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
        $oldStory = Story::find($id);
        if($oldStory){
            $oldStory->delete();
        }
        $story = new Story();
        if($story){
            $story->storyName = $request->input('storyName');
            $story->content = $request->input('content');
            $story->writerName = $request->input('writerName');
            $story->groupId = $request->input('groupId');
            $story->UserMainID = $request->input('UserMainID');
            $story->save();
            return ["id"=>$story->id];
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
        $story = Story::find($id);
        if($story)
            $story->delete();
    }
    public function upImage(Request $request){
        $cosApi = new Api($this->config());
        $bucket = 'mufengpaobu';
        $dstPath =$request->image;
        $newName=str_random(6).'.'.explode("/", $request->image->getClientMimeType())[1];
        $bizAttr = "/story/".$newName;
        $result = $cosApi->upload($bucket,$dstPath,$bizAttr);
        $image = new StoryImage();
        $image->url = $newName;
        $image->storyId = $request->input('id');
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
        $temp = Story::orderBy("id","desc")->where('state','=','1')->get();
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
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/story/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
            $temp2 = array('time'=>date('Y-m-d',$date));
            $res[$i] = array_merge($res[$i],$temp2);
        }
        return $res;
    }
    public function pageReDu($page){
        $eachNum = 6;
        $start = ($page-1) * $eachNum;
        $end = $page*$eachNum;
        $temp = Story::orderBy("zanNum","desc")->where('state','=','1')->get();
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
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/story/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
            $temp2 = array('time'=>date('Y-m-d',$date));
            $res[$i] = array_merge($res[$i],$temp2);
        }
        return $res;
    }
    function storyZan($id,$UserMainID){
        $zanlog = ZanLog::where('storyID','=',$id)->where('UserMainID','=',$UserMainID)->get();
        $story = Story::find($id);
        if(count($zanlog)>0){
            $zanlog[0]->delete();
            $story->zanNum = $story->zanNum - 1;
            $story->update();
        }else {
            $story->zanNum = $story->zanNum + 1;
            $story->update();
            $newlog = new ZanLog();
            $newlog->storyID = $id;
            $newlog->UserMainID = $UserMainID;
            $newlog->save();
        }
        return ['num'=>$story->zanNum];
    }
    function findStory(Request $request){
        $name = $request->input('name');
        $datas = Story::where('storyName','like','%'.$name.'%')->get();

        $res = $datas->toArray();
        $len = count($datas);
        for($i = 0;$i<$len;$i++){
            if(count($datas[$i]->images()->get())>0) {
                //echo $res[$i]->images()->get()[0];
                //dd($res[$i]->images()->get()[0]->url);
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/story/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
        }
        return $res;
    }
    function storyCheck($groupId){
        $res = Story::orderBy('id','desc')->where('groupId','=',"$groupId")->where('state','=','0')->get();
        return $res->toArray();
    }
    function checkStory(Request $request){
        $storyId = $request->input("storyId");
        $story = Story::find($storyId);
        if($request->option=='accept'){
            $story->state = 1;
            $story->save();
        }else{
            $story->delete();
        }
    }
    function comment(Request $request){
        $comment = new Comment();
        $comment->foreign_key = $request->input('id');
        $comment->type = $request->input('type');
        $comment->name = $request->input('name');
        $comment->content = $request->input('content');
        $comment->HeadImgUrl = $request->input('HeadImgUrl');
        $comment->save();
    }
    function getComment($id,$type){
        $res = array();
        $comments = Comment::orderBy('id','desc')->where('foreign_key','=',$id)->where('type','=',$type)->get();
        for($i = 0;$i<count($comments);$i++){
            $commentId = $comments[$i]->id;
            $replys = Reply::orderBy('id','desc')->where('foreign_key','=',$commentId)->where('type','=',$type)->get();
            array_push($res,$comments[$i]->toArray());
            array_push($res[$i],$replys);
        }
        return $res;
    }
    function reply(Request $request){
        $reply = new Reply();
        $reply->name = $request->input('name');
        $reply->foreign_key = $request->input('commentId');
        $reply->content = $request->input('content');
        $reply->type = $request->input('type');
        $reply->HeadImgUrl = $request->input('HeadImgUrl');
        $reply->save();
    }
    function myStory($id,$page){
        $eachNum = 6;
        $start = ($page-1) * $eachNum;
        $end = $page*$eachNum;
        $temp = Story::orderBy("id","desc")->where('UserMainID','=',$id)->get();
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
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/story/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
            $temp2 = array('time'=>date('Y-m-d',$date));
            $res[$i] = array_merge($res[$i],$temp2);
        }
        return $res;
    }
    //查找我的故事
    function findMyStory(Request $request){
        $name = $request->input('name');
        $UserMainID = $request->input('UserMainID');
        $datas = Story::where('UserMainID','=',$UserMainID)->where('storyName','like','%'.$name.'%')->get();

        $res = $datas->toArray();
        $len = count($datas);
        for($i = 0;$i<$len;$i++){
            if(count($datas[$i]->images()->get())>0) {
                //echo $res[$i]->images()->get()[0];
                //dd($res[$i]->images()->get()[0]->url);
                $url = "https://mufengpaobu-1254292520.cos.ap-beijing.myqcloud.com/story/" . $datas[$i]->images()->get()[0]->url ;
                $temp = array('image'=>$url);
                $res[$i] = array_merge($res[$i],$temp);
            }
        }
        return $res;
    }
    function dashang(Request $request){
        $bossID = $request->input('bossID');
        $ownerID = $request->input('UserMainID');
        $owner = UserMain::find($ownerID);
        $boss = UserMain::find($bossID);
        $num = $request->input('num');
        if($boss->TotalPoints>=$num){
            $boss->TotalPoints = $boss->TotalPoints - $num;
            $boss->update();
            $owner->TotalPoints = $owner->TotalPoints + $num;
            $owner->update();
        }else{
            return ['state'=>0];
        }
        $dashang = new DaShang();
        $dashang->storyId = $request->input('storyID');
        $dashang->num = $request->input('num');
        $dashang->UserMainID = $request->input('UserMainID');
        $dashang->bossID = $request->input('bossID');
        $dashang->save();
        return ['state'=>1];
    }
}
