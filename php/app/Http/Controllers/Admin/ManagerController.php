<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ManagerController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod("post")){

            $name=$request->input("username");
            $pwd=$request->input("password");

            $res= Auth::guard("admin")->attempt(['username'=>$name,'password'=>$pwd]);
//            dd($name,$pwd,$res);
            if($res)
            {
                return redirect("admin/index/index");
            }
            else
                {
                  return  redirect("admin/manager/login")->withErrors(["errorinfo"=>"用户名或账号错误"])->withInput();
                }


        }else{
            return view("admin/manager/login");
        }


    }

    public function showlist(Request $request,Manager $manager)
    {
       $info= $manager->get();
        return view("admin/manager/showlist",['info'=>$info]);
    }

    public function tianjia(Request $request)
    {
        if($request->isMethod('post')){
          $shuju=$request->all();
          $shuju['password']=bcrypt($shuju['password']);

          if(Manager::create($shuju)){
              return ['success'=>true];
          }else{
              return ['success'=>false];

          }


        }else{
            return view("admin/manager/tianjia");

        }

    }
    
//    修改管理员
    public function xiugai(Request $request,Manager $manager)
    {
//        dd($manager);

//        dd($data);
        if ($request->isMethod('post')){
            $data=$request->all();
           $res= $manager->update($data);
           if($res){
               return ['success'=>true];
           }else{
               return ['success'=>false];
           }
        }else{
            return view("admin/manager/xiugai",["manager"=>$manager]);
        }

    }

    public function del(Manager $manager)
    {
        $res=$manager->delete();
        if ($res){
            return ['success'=>true];
        }else{
            return ['success'=>false];
        }
    }
}
