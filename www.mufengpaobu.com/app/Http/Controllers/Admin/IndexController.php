<?php



namespace App\Http\Controllers\Admin;



use App\Http\Model\Administrator;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Crypt;



class IndexController extends CommonController{

    public function index()

    {

        //按、、内容排序，前6名的

//        $hot=User数据表名::orderBy('字段名','desc')->take(6)->get();

//        //列表带分页

//        $data=User数据表名::orderBy('字段名','desc')->paginate(5);

//        return view('admin.index',compact('hot','data'));

        //选特定属性的内容排序

        //$data=User数据表名::where('字段名',1)->orderBy('字段名','desc')->paginate(5);

        $user_main = DB::table('usermain')

            ->count();

        $user_captain = DB::table('groups')

            ->count();

        $user_businessmen = DB::table('MyGroup')

            ->where('Type', 2)

            ->count();

        $group_wait = DB::table('groups')

            ->where('State', 0)

            ->count();

        $adv_wait = DB::table('groups')

            ->where('AdvState', 1)

            ->count();

        return view('admin.index')->with(['group_wait'=>$group_wait,'user_main'=>$user_main,'adv_wait'=>$adv_wait,'user_captain'=>$user_captain,'user_businessmen'=>$user_businessmen]);

    }

    //修改密码

    public function changepass(){

        if($input=Input::all()){

            $rules=[

                'user-new-pas'=>'between:8,16|confirmed',

            ];

            $message=[

                'user-new-pas.between'=>"*新密码必须在8-16位之间",

                'user-new-pas.confirmed'=>"*两次输入的新密码不一致",

            ];

            $validator=Validator::make($input,$rules,$message) ;

            if($validator->passes()){

                $administrator=Administrator::first();

                $_password=Crypt::decrypt($administrator->Password);

                if($input['user-old-pas'] == $_password){

                    $administrator->Password=Crypt::encrypt($input['user-new-pas']);

                    $administrator->update();

                    //方案1

                    session(['administrator'=>null]);

                    return redirect('login');

                    //方案2

//                    return back()->with('errors','密码修改成功！');

                }else{

                    return back()->with('errors','原密码错误');

                }

            }else{

                return back()->withErrors($validator);

            }

        }else{

            return view('admin.second.changepass');

        }

    }

    //管理员退出

    public function quit(){

        session(['administrator'=>null]);

        return redirect('login');

    }



}

