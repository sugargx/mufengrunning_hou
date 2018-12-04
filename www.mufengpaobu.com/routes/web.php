<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('index.home');
});
Route::get('/view', function () {
    return view('test');
});
//跑步故事

Route::get('storyPage/{page}','WxStoryController@page');//武志祥
Route::get('storyPageReDu/{page}','WxStoryController@pageReDu');//武志祥
Route::post('image','WxStoryController@upImage');//武志祥
Route::get('zanNum/{id}/{UserMainID}','WxStoryController@storyZan');//武志祥
Route::post('/findStory','WxStoryController@findStory');//武志祥
Route::get('/storyCheck/{GroupId}','WxStoryController@storyCheck');//武志祥
Route::post('/storyCheck','WxStoryController@checkStory');//武志祥
Route::post('/comment','WxStoryController@comment');//武志祥
Route::get('comment/{id}/{type}','WxStoryController@getComment');//武志祥
Route::post('reply','WxStoryController@reply');//武志祥
Route::get('myStory/{id}/{page}','WxStoryController@myStory');//武志祥
Route::post('findMyStory','WxStoryController@findMyStory');//武志祥
Route::post('/dashang',"WxStoryController@dashang");//武志祥
//装备

Route::post('equipmentImage','WxEquipmentController@upImage');//武志祥
Route::get('equipmentPage/{page}','WxEquipmentController@page');//武志祥
Route::post('/findEquipment','WxEquipmentController@findEquipment');//武志祥
Route::get('/equipmentCheck/{GroupId}','WxEquipmentController@equipmentCheck');//武志祥
Route::post('/equipmentCheck','WxEquipmentController@checkEquipment');//武志祥
Route::post('/findMyEquipment','WxEquipmentController@findMyEquipment');//武志祥

Route::get('/getNum/{groupId}/{type}',"WxEquipmentController@getNum");//武志祥
Route::get('myManagerGroup/{id}',"WxEquipmentController@myManagerGroup");//武志祥
Route::get('myGroup/{id}',"WxEquipmentController@myGroup");//武志祥
Route::get('myEquipment/{id}/{page}','WxEquipmentController@myEquipment');//武志祥


Route::get('/CLearZHANGDI', 'WxControllerUP@CLearZHANGDI');//张迪
Route::get('/GroupMOvE', 'WxControllerUP@GroupMOvE');//张迪
Route::post('/uploadimg', 'WxControllertest@uploadimg');//张迪
Route::get('/data', 'DbController@index');//张迪
Route::post('/upload',"UpController@index");//张迪
Route::get('/index',"WxController@index");//张迪
Route::get('/getopenid',"WxController@getopenid");//张迪
Route::get('/runGroup',"WxController@runGroup");//张迪
Route::get('/allGroup',"WxController@allGroup");//张迪
Route::get('/teamIntroduce',"WxController@teamIntroduce");//张迪
Route::get('/getAdv',"WxController@getAdv");//张迪
Route::get('/uploaduserinfo',"WxController@uploaduserinfo");//张迪
Route::post('/creatGroup',"WxController@creatGroup");//张迪
Route::get('/applyGroup',"WxController@applyGroup");//张迪
Route::get('/checkTime',"WxController@checkTime");//张迪
Route::post('/uploading',"WxController@uploading");//张迪
Route::get('/upSuccess',"WxController@upSuccess");//张迪
Route::get('/GroupAnalyse',"WxController@GroupAnalyse");//张迪
Route::get('/getMyGroupState',"WxController@getMyGroupState");//张迪
Route::get('/getMyUploadFlag',"WxController@getMyUploadFlag");//张迪
Route::get('/MyAnalyse',"WxController@MyAnalyse");//张迪
Route::get('/getRunImg',"WxController@getRunImg");//张迪
Route::get('/find',"WxController@find");//张迪
Route::get('/getImg',"WxController@getImg");//张迪
Route::get('/checkName',"WxController@checkName");//张迪
Route::get('/getIndex',"WxController@getIndex");//张迪
Route::get('/getMy',"WxController@getMy");//张迪
Route::get('/quitGroup',"WxController@quitGroup");//张迪
Route::get('/getAccount',"WxController@getAccount");//张迪
Route::any('/changeGroupInfo',"WxController@changeGroupInfo");//张迪
Route::post('/test',"WxController_hkf@test");//张迪
Route::get('/ceshi',"WxController@ceshi");//张迪
Route::get('/agree',"WxController@agree");//张迪
Route::get('/noAgree',"WxController@noAgree");//张迪
Route::get('/getMyState',"WxController@getMyState");//张迪
Route::get('/getMyRunList',"WxController@getMyRunList");//张迪
Route::get('/runDetail',"WxController@runDetail");//张迪
Route::get('/getApplicants',"WxController_hkf@getApplicants");//郝开发 获取申请人信息
Route::get('/getGroupPeo',"WxController_hkf@getGroupPeo");//郝开发
Route::get('/getGroupInfo',"WxController_hkf@getGroupInfo");//郝开发
Route::post('/changeGroupInfo2',"WxController_hkf@changeGroupInfo2");//郝开发
Route::get('/creatAdv1',"WxController_hkf@creatAdv1");//郝开发
Route::post('/creatAdv2',"WxController_hkf@creatAdv2");//郝开发
Route::post('/creatAdv3',"WxController_hkf@creatAdv3");//郝开发
Route::get('/remove',"WxController_hkf@remove");//张迪
Route::get('/Report',"WxController@Report");//张迪
Route::get('/getReport',"WxController@getReport");//张迪
Route::get('/getZhangdi',"WxController@getZhangdi");//张迪



Route::get('/removeDatebaseUP',"WxControllerUP@removeDatebase");//app.js
Route::get('/getopenidUP',"WxControllerUP@getopenid");//app.js
Route::get('/getMyGroupStateUP',"WxControllerUP@getMyGroupState");//
Route::get('/getIndexUP',"WxControllerUP@getIndex");//index.js
Route::get('/indexUP',"WxControllerUP@index");//index.js
Route::get('/getMyGroupListUP',"WxControllerUP@getMyGroupList");//teamManage.js
Route::get('/getApplicantsUP',"WxControllerUP@getApplicants");//manage.js
Route::get('/getAccountUP',"WxControllerUP@getAccount");//manage.js
Route::get('/getGroupInfoUP',"WxControllerUP@getGroupInfo");//info.js
Route::any('/changeGroupInfoUP',"WxControllerUP@changeGroupInfo");//info.js
Route::get('/getGroupPeoUP',"WxControllerUP@getGroupPeo");//member.js
Route::get('/removeUP',"WxControllerUP@remove");//member.js
Route::get('/agreeUP',"WxControllerUP@agree");//check.js
Route::get('/noAgreeUP',"WxControllerUP@noAgree");//check.js
Route::post('/uploadingUP',"WxControllerUP@uploading");//杨亚超uploading.js
Route::post('/creatGroupUP',"WxControllerUP@creatGroup");//creatGroup.js
Route::get('/applyGroupUP',"WxControllerUP@applyGroup");//teamIntroduce.js
Route::get('/upSuccessUP',"WxControllerUP@upSuccess");//杨亚超 uploading.js
Route::get('/quitGroupUP',"WxControllerUP@quitGroup");//teamIntroduce.js
Route::get('/getMyUP',"WxControllerUP@getMy");//index.js
Route::get('/getMyRunListUP',"WxControllerUP@getMyRunList");//record.js
Route::get('/MyAnalyseUP',"WxControllerUP@MyAnalyse");//analysis1.js
Route::get('/RemoveRunUP',"WxControllerUP@RemoveRun");//record.js
Route::get('/teamIntroduceUP',"WxControllerUP@teamIntroduce");//teamIntroduce.js
Route::get('/rankListUP',"WxControllerUP@rankList");//rankList.js
Route::get('/GroupAnalyseUP',"WxControllerUP@GroupAnalyse");//analysis.js
Route::get('/dismissGroupUP',"WxControllerUP@dismissGroup");//teamIntroduce.js解散跑团

/*
Route::post('/uploadimgUP', 'WxControllertestUP@uploadimg');//张迪

Route::get('/dataUP', 'DbControllerUP@index');//张迪
Route::post('/uploadUP',"UpControllerUP@index");//张迪


Route::get('/runGroupUP',"WxControllerUP@runGroup");//张迪
Route::get('/allGroupUP',"WxControllerUP@allGroup");//张迪

Route::get('/getAdvUP',"WxControllerUP@getAdv");//张迪
Route::get('/uploaduserinfoUP',"WxControllerUP@uploaduserinfo");//张迪
Route::get('/checkTimeUP',"WxController@checkTime");//张迪

Route::get('/getMyUploadFlagUP',"WxControllerUP@getMyUploadFlag");//张迪
Route::get('/getRunImgUP',"WxControllerUP@getRunImg");//张迪
Route::get('/findUP',"WxControllerUP@find");//张迪
Route::get('/getImgUP',"WxControllerUP@getImg");//张迪
Route::get('/checkNameUP',"WxControllerUP@checkName");//张迪
Route::post('/testUP',"WxController_hkfUP@test");//张迪
Route::get('/ceshiUP',"WxControllerUP@ceshi");//张迪
Route::get('/getMyStateUP',"WxControllerUP@getMyState");//张迪
Route::get('/runDetailUP',"WxControllerUP@runDetail");//张迪
Route::post('/changeGroupInfo2UP',"WxController_hkfUP@changeGroupInfo2");//郝开发
Route::get('/creatAdv1UP',"WxController_hkfUP@creatAdv1");//郝开发
Route::post('/creatAdv2UP',"WxController_hkfUP@creatAdv2");//郝开发
Route::post('/creatAdv3UP',"WxController_hkfUP@creatAdv3");//郝开发
Route::get('/ReportUP',"WxControllerUP@Report");//张迪
Route::get('/getReportUP',"WxControllerUP@getReport");//张迪
*/





/*后台路由*/
Route::get('mall','admin\MallController@index');//赵思宇
Route::any('login','Admin\LoginController@login');//赵思宇
Route::get('admin/code','Admin\LoginController@code');//赵思宇
Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware'=>['web']], function () { //,'admin.login'
    Route::resource('user', 'UserController');//赵思宇
    Route::get('limit','UserController@limit');//赵思宇
    Route::resource('mall', 'MallController');//赵思宇
    Route::get('show_user/{username}','CommonController@show_user');//赵思宇
    Route::resource('common', 'CommonController');//赵思宇
    Route::get('quit','IndexController@quit');//赵思宇
    Route::get('index','IndexController@index');//赵思宇
    Route::any('changepass','IndexController@changepass');//赵思宇
    Route::resource('carousel', 'CarouselController');//赵思宇
    Route::post('carousel/del/{del}','CarouselController@del');//赵思宇
    Route::resource('group', 'GroupController');//赵思宇
    Route::post('group/del_adv/{del}','GroupController@del_adv');//赵思宇
    Route::post('group/del_user/{del}','GroupController@del_user');//赵思宇
    Route::get('find','GroupController@find');//赵思宇
    Route::get('group/disuse/{disuse}','GroupController@groupdisuse');//赵思宇
    Route::get('group/use/{use}','GroupController@groupuse');//赵思宇
    Route::get('group/nopass/{nopass}','GroupController@nopass');//赵思宇
    Route::get('advertiseindex/{groupid}','AdvertiseController@index');//赵思宇
    Route::get('advertiselook/{groupid}','AdvertiseController@advlook');//赵思宇
    Route::get('advertiseother/{groupid}','AdvertiseController@advother');//赵思宇
    Route::post('advertise/addindex/{groupid}','AdvertiseController@adv_add');//赵思宇
    Route::post('advertise/addother/{groupid}','AdvertiseController@adv_addother');//赵思宇
    Route::get('advertise/advertisenopass/{groupid}','AdvertiseController@advertisenopass');//赵思宇
   
});

Route::group(['prefix' => 'group','namespace' => 'Admin','middleware'=>['web','group.login']], function () {
    Route::resource('groupindex', 'GroupIndexController');//赵思宇
//    Route::any('groupindex/img_up', 'GroupIndexController@img_up');//赵思宇
    Route::post('groupindex/del_user/{del}', 'GroupIndexController@del_user');//赵思宇
    Route::get('groupindex/group_user/{user}', 'GroupIndexController@group_user');//赵思宇
    Route::get('groupindex/group_pass/{pass}', 'GroupIndexController@group_pass');//赵思宇
    Route::any('groupindex/group_adv/{user}', 'GroupIndexController@group_adv');//赵思宇
    Route::get('groupindex/group_runs/{runs}', 'GroupIndexController@group_runs');//赵思宇
    Route::get('excel_month/{groupid}','ExcelController@excel_month');//赵思宇
    Route::get('excel_peopleWeek/{groupid}','ExcelController@excel_peopleWeek');//赵思宇
//    Route::get('excel_week/{groupid}','ExcelController@excel_week');//赵思宇
//    Route::get('excel_year/{groupid}','ExcelController@excel_year');//赵思宇
//    Route::get('excel_season/{groupid}','ExcelController@excel_season');//赵思宇
    Route::get('groupindex/pass/{userid}','GroupIndexController@pass');//赵思宇
    Route::get('groupindex/nopass/{userid}','GroupIndexController@nopass');//赵思宇
    Route::any('groupindex/points_down/{userid}/{points}','GroupIndexController@points_down');//赵思宇
    Route::get('groupindex/advlook/{groupid}','GroupIndexController@group_advlook');//赵思宇
});
/*结束*/