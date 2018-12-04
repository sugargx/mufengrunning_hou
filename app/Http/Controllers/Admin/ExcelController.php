<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;





class ExcelController extends CommonController

{

//    public function excel_week($id){
//
//        $week=date('w',time());
//
//        if( $week == 0){
//
//            $runs=DB::table('run')
//
//                ->where('GroupID', $id)
//
//                ->whereDate('Date','>',date('Y-m-d h:i:s',time()-7*24*60*60))
//
//                ->whereDate('Date','<=',date('Y-m-d h:i:s',time()))
//
//                ->orderBy('Date','asc')
//
//                ->get();
//
//        }else{
//
//            $runs=DB::table('run')
//
//                ->where('GroupID', $id)
//
//                ->whereDate('Date','>',date('Y-m-d h:i:s',time()-$week*24*60*60))
//
//
//                ->orderBy('Date','asc')
//
//                ->get();
//
//        }
//
//        $run_point=0;
//        $run_time=0;
//        $run_long=0;
//
//        foreach($runs as $k => $v) {
//
//            $name=DB::table("usermain")->where('Id',$v->UserMainID)->first();
//
//            $v->Name=$name->Name;
//
//            $run_point+=$v->Point;
//
//            $run_time+=$v->TimeLong;
//
//            $run_long+=$v->Distance;
//        }
//
//        $cellData = [
//
//            ['总跑步里程(公里)：',$run_long,'总跑步时长：',(int)($run_time/3600)."时".(int)($run_time/60)."分".(int)( $run_time%60)."秒",'总积分：',$run_point],
//
//            ['姓名','跑步里程(公里)','跑步时长','打卡时间','此次积分'],
//
//        ];
//
//        foreach($runs as $k=> $v ){
//
//            $data=[[$v->Name,$v->Distance,(int)($v->TimeLong/3600)."时".(int)($v->TimeLong/60)."分".(int)( $v->TimeLong%60)."秒",$v->Date,$v->Point],];
//
//            $cellData = array_merge($cellData,$data);
//
//        }
//
//        Excel::create("跑步周信息",function ($excel) use ($cellData){
//
//            $excel->sheet('score',function ($sheet) use ($cellData) {
//
//                $sheet->rows($cellData);
//
//            });
//
//        })->export('xls');
//
//    }

    public function excel_month(Request $request, $id)
    {
        
        $my = DB::table('MyGroup')
            ->where('GroupID', $id)
            ->orderBy('Type', 'asc')
            ->get();

       $time_begin = $request->input('time_begin1')."-".$request->input('time_begin2')."-".$request->input('time_begin3');

       $time_end = $request->input('time_end1')."-".$request->input('time_end2')."-".$request->input('time_end3');

        $sum_point = 0;

        $sum_time = 0;

        $sum_long = 0;

        foreach ($my as $k => $v) {

            $name = DB::table("usermain")->where('Id', $v->UserMainID)->first();

            $v->Name = $name->Name;

            $v->run_point = DB::table('run')
                ->where('UserMainID', $v->UserMainID)
                ->where('disRepeat',0)
                ->whereDate('Date', '>=', $time_begin)
                ->whereDate('Date', '<=', $time_end)
                ->sum('Point');

            $v->run_time = DB::table('run')
                ->where('UserMainID', $v->UserMainID)
                ->where('disRepeat',0)
                ->whereDate('Date', '>=', $time_begin)
                ->whereDate('Date', '<=', $time_end)
                ->sum('TimeLong');

            $v->run_long = DB::table('run')
                ->where('UserMainID', $v->UserMainID)
                ->where('disRepeat',0)
                ->whereDate('Date', '>=', $time_begin)
                ->whereDate('Date', '<=', $time_end)
                ->sum('Distance');

            $sum_point += $v->run_point;

            $sum_time += $v->run_time;

            $sum_long += $v->run_long;

        }


        $cellData = [

            ['总跑步里程(公里)','总跑步时长','总积分','起始时间','终止时间'],

            [$sum_long,(int)($sum_time/3600)."时".(int)($sum_time/60%60)."分".(int)( $sum_time%60)."秒",$sum_point,$time_begin,$time_end,],

            ['姓名', '总跑步里程(公里)', '总跑步时长', '总积分'],

        ];

        foreach ($my as $k => $v) {

            $data = [[$v->Name, $v->run_long, $v->run_time, $v->run_point],];

            $cellData = array_merge($cellData, $data);

        }

        Excel::create("跑步信息", function ($excel) use ($cellData) {

            $excel->sheet('score', function ($sheet) use ($cellData) {

                $sheet->rows($cellData);

            });

        })->export('xls');


    }

//    public function excel_year($id){
//
//        $runs=DB::table('run')
//
//            ->where('GroupID', $id)
//
//            ->whereYear('Date',date('Y',time()))
//
//            ->orderBy('Date','asc')
//
//            ->get();
//
//        $run_point=0;
//        $run_time=0;
//        $run_long=0;
//
//        foreach($runs as $k => $v) {
//
//            $name=DB::table("usermain")->where('Id',$v->UserMainID)->first();
//
//            $v->Name=$name->Name;
//
//            $run_point+=$v->Point;
//
//            $run_time+=$v->TimeLong;
//
//            $run_long+=$v->Distance;
//        }
//
//        $cellData = [
//
//            ['总跑步里程(公里)：',$run_long,'总跑步时长：',(int)($run_time/3600)."时".(int)($run_time/60)."分".(int)( $run_time%60)."秒",'总积分：',$run_point],
//
//            ['姓名','跑步里程(公里)','跑步时长','打卡时间','此次积分'],
//
//        ];
//
//        foreach($runs as $k=> $v ){
//
//            $data=[[$v->Name,$v->Distance,(int)($v->TimeLong/3600)."时".(int)($v->TimeLong/60)."分".(int)( $v->TimeLong%60)."秒",$v->Date,$v->Point],];
//
//            $cellData = array_merge($cellData,$data);
//
//        }
//
//        Excel::create("跑步年信息",function ($excel) use ($cellData){
//
//            $excel->sheet('score',function ($sheet) use ($cellData) {
//
//                $sheet->rows($cellData);
//
//            });
//
//        })->export('xls');
//
//    }

//    public function excel_season($id){
//
//        if(date('m',time()) >= 1 && date('m',time()) < 4){
//
//            $runs=DB::table('run')
//
//                ->where('GroupID', $id)
//
//                ->whereYear('Date',date('Y',time()))
//
//                ->whereMonth('Date','>=',1)
//
//                ->whereMonth('Date','<',4)
//
//                ->orderBy('Date','asc')
//
//                ->get();
//
//        }elseif (date('m',time()) >= 4 && date('m',time()) < 7){
//
//            $runs=DB::table('run')
//
//                ->where('GroupID', $id)
//
//                ->whereYear('Date',date('Y',time()))
//
//                ->whereMonth('Date','>=',4)
//
//                ->whereMonth('Date','<',7)
//
//                ->orderBy('Date','asc')
//
//                ->get();
//
//        }elseif (date('m',time()) >= 7 && date('m',time()) < 10){
//
//            $runs=DB::table('run')
//
//                ->where('GroupID', $id)
//
//                ->whereYear('Date',date('Y',time()))
//
//                ->whereMonth('Date','>=',7)
//
//                ->whereMonth('Date','<',10)
//
//                ->orderBy('Date','asc')
//
//                ->get();
//
//        }else{
//
//            $runs=DB::table('run')
//
//                ->where('GroupID', $id)
//
//                ->whereYear('Date',date('Y',time()))
//
//                ->whereMonth('Date','>=',10)
//
//                ->whereMonth('Date','<',12)
//
//                ->orderBy('Date','asc')
//
//                ->get();
//
//        }
//
//        $run_point=0;
//        $run_time=0;
//        $run_long=0;
//
//        foreach($runs as $k => $v) {
//
//            $name=DB::table("usermain")->where('Id',$v->UserMainID)->first();
//
//            $v->Name=$name->Name;
//
//            $run_point+=$v->Point;
//
//            $run_time+=$v->TimeLong;
//
//            $run_long+=$v->Distance;
//        }
//
//        $cellData = [
//
//            ['总跑步里程(公里)：',$run_long,'总跑步时长：',(int)($run_time/3600)."时".(int)($run_time/60)."分".(int)( $run_time%60)."秒",'总积分：',$run_point],
//
//            ['姓名','跑步里程(公里)','跑步时长','打卡时间','此次积分'],
//
//        ];
//
//        foreach($runs as $k=> $v ){
//
//            $data=[[$v->Name,$v->Distance,(int)($v->TimeLong/3600)."时".(int)($v->TimeLong/60)."分".(int)( $v->TimeLong%60)."秒",$v->Date,$v->Point],];
//
//            $cellData = array_merge($cellData,$data);
//
//        }
//
//        Excel::create("跑步季信息",function ($excel) use ($cellData){
//
//            $excel->sheet('score',function ($sheet) use ($cellData) {
//
//                $sheet->rows($cellData);
//
//            });
//
//        })->export('xls');
//
//    }

    //下载个人月跑量表
    public function excel_peopleWeek($id){
        $input = Input::all();
        if (!$input['excel-name']) {
            return back()->with('errors','跑团内不存在此人');
        }
        $name = DB::table('usermain')
            ->where('Name',$input['excel-name'])
            ->first();

        if(!$name){
            return back()->with('errors','跑团内不存在此人');
        }
        $name = $name->Id;

        $pass = DB::table('MyGroup')
            ->where('UserMainID',$name)
            ->where('GroupID', $id)
            ->first();
        if(!$pass){
            return back()->with('errors','跑团内不存在此人');
        }

        $runs=DB::table('run')
            ->where('GroupID', $id)
            ->where('UserMainID',$name)
            ->whereYear('Date',date('Y',time()))
            ->whereMonth('Date',date('m',time()))
            ->orderBy('Date','asc')
            ->get();


        foreach($runs as $k => $v) {
            $name1=DB::table("usermain")->where('Id',$v->UserMainID)->first();
            $v->GroupName=$name1->GroupName;
            $v->Name=$name1->Name;
        }
        $cellData = [

            ['姓名','跑步里程(公里)','跑步时长','打卡时间','此次积分','跑团名称'],
        ];
        foreach($runs as $k=> $v ){
            $data=[[$v->Name,$v->Distance,(int)($v->TimeLong/3600)."时".(int)($v->TimeLong/60%60)."分".(int)( $v->TimeLong%60)."秒",$v->Date,$v->Point,$v->GroupName],];
            $cellData = array_merge($cellData,$data);
        }
        Excel::create($input['excel-name']."个人跑步月信息",function ($excel) use ($cellData){
            $excel->sheet('score',function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');


    }
}



