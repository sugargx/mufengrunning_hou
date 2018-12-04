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
    return view('welcome');
});
Route::get('/view', function () {
    return view('test');
});

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
//Route::get('/testGetQRcode','test@testGetQRcode');//张迪
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



/*后台路由*/
Route::any('login','Admin\LoginController@login');
Route::get('admin/code','Admin\LoginController@code');
Route::group(['prefix' => 'admin','namespace' => 'Admin','middleware'=>['web','admin.login']], function () {
    Route::resource('user', 'UserController');
    Route::get('limit','UserController@limit');
    Route::resource('mall', 'MallController');
    Route::get('show_user/{username}','CommonController@show_user');
    Route::resource('common', 'CommonController');
    Route::get('quit','IndexController@quit');
    Route::get('index','IndexController@index');
    Route::any('changepass','IndexController@changepass');
    Route::resource('carousel', 'CarouselController');
    Route::post('carousel/del/{del}','CarouselController@del');
    Route::resource('group', 'GroupController');
    Route::post('group/del_adv/{del}','GroupController@del_adv');
    Route::post('group/del_user/{del}','GroupController@del_user');
    Route::get('find','GroupController@find');
    Route::get('group/disuse/{disuse}','GroupController@groupdisuse');
    Route::get('group/use/{use}','GroupController@groupuse');
    Route::get('group/nopass/{nopass}','GroupController@nopass');
    Route::get('advertiseindex/{groupid}','AdvertiseController@index');
    Route::get('advertiselook/{groupid}','AdvertiseController@advlook');
    Route::get('advertiseother/{groupid}','AdvertiseController@advother');
    Route::post('advertise/addindex/{groupid}','AdvertiseController@adv_add');
    Route::post('advertise/addother/{groupid}','AdvertiseController@adv_addother');
    Route::get('advertise/advertisenopass/{groupid}','AdvertiseController@advertisenopass');
});

Route::group(['prefix' => 'group','namespace' => 'Admin','middleware'=>['web','group.login']], function () {
    Route::resource('groupindex', 'GroupIndexController');
//    Route::any('groupindex/img_up', 'GroupIndexController@img_up');
    Route::post('groupindex/del_user/{del}', 'GroupIndexController@del_user');
    Route::get('groupindex/group_user/{user}', 'GroupIndexController@group_user');
    Route::get('groupindex/group_pass/{pass}', 'GroupIndexController@group_pass');
    Route::any('groupindex/group_adv/{user}', 'GroupIndexController@group_adv');
    Route::get('groupindex/group_runs/{runs}', 'GroupIndexController@group_runs');
    Route::get('excel_month/{groupid}','ExcelController@excel_month');
    Route::get('excel_week/{groupid}','ExcelController@excel_week');
    Route::get('excel_year/{groupid}','ExcelController@excel_year');
    Route::get('excel_season/{groupid}','ExcelController@excel_season');
    Route::get('groupindex/pass/{userid}','GroupIndexController@pass');
    Route::get('groupindex/nopass/{userid}','GroupIndexController@nopass');
    Route::any('groupindex/points_down/{userid}/{points}','GroupIndexController@points_down');
    Route::get('groupindex/advlook/{groupid}','GroupIndexController@group_advlook');
});
/*结束*/


