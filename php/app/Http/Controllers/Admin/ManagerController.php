<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
//    登录控制器
    public function login(Request $request)
    {
        if ($request->isMethod("post")) {
            $rules =
                [
                    'username' => 'required',
                    'password' => 'required',
                    'yanzh' => 'required|captcha',
                ];

            $notices =
                [
                    'username.required' => "用户名必须填写",
                    'password.required' => "密码必须填写",
                    'yanzh.required' => "验证码必须填写",
                    'yanzh.captcha' => "验证码填写错误",
                ];

            $validator = Validator::make($request->all(), $rules, $notices);
//            dd($validator->passes());
            if ($validator->passes()) {
                $name = $request->input("username");
                $pwd = $request->input("password");

                $res = Auth::guard("admin")->attempt(['username' => $name, 'password' => $pwd]);
//            dd($name,$pwd,$res);
                if ($res) {
                    return redirect("admin/index/index");
                } else {
                    return redirect("admin/manager/login")->withErrors(["errorinfo" => "用户名或账号错误"])->withInput();
                }


            } else {
                return redirect("admin/manager/login")->withErrors($validator)->withInput();
            }

        } else {
            return view("admin/manager/login");
        }
    }

//    展示控制器

    public function showlist(Request $request, Manager $manager)
    {
        $info = $manager->get();
        return view("admin/manager/showlist", ['info' => $info]);
    }

//    添加用户的控制器
    public function tianjia(Request $request)
    {
        if ($request->isMethod('post')) {


//            $this->validate($request, [
//                'title' => 'required|unique:posts|max:255',
//                'author.name' => 'required',
//                'author.description' => 'required',
//            ]);


            $rules =
                [
                    "username" => "required|unique:manager,username|min:4|max:12",
                    "password" => "required|confirmed",
                    "mg_email" => "required|email",
                    "mg_phone" => ["required", "regex:/^1[3587]\d{9}$/"],
                ];
            $notices =
                [
                    "username.required" => "用户名必须写",
                    "username.unique" => "用户名已被占用",
                    "username.min" => "用户名最少4位",
                    "username.max" => "用户名最多12位",
                    "password.required" => "密码必须写",
                    "password.confirmed" => "密码输入不一致",
                    "mg_email.required" => "邮箱必须填写",
                    "mg_email.emai" => "邮箱填写格式不正确",
                    "mg_phone.required" => "手机号必须填写",
                    "mg_phone.regex" => "手机格式填写不正确",

                ];
//            dd($request->all());
            $validator = Validator::make($request->all(), $rules, $notices);
//            dd($validator);
            if ($validator->passes()) {
                $shuju = $request->all();
                $shuju['password'] = bcrypt($shuju['password']);
                Manager::create($shuju);
                return ['success' => true];
            } else {
//                dd(collect($validator->messages()));
                $errorinfo = collect($validator->messages())->implode("0", "|");
                return ['success' => false, "errorinfo" => $errorinfo];

            }
        } else {
            return view("admin/manager/tianjia");

        }

    }

//    修改管理员
    public function xiugai(Request $request, Manager $manager)
    {
//        dd($manager);

//        dd($data);
        if ($request->isMethod('post')) {
            $data = $request->all();
            $res = $manager->update($data);
            if ($res) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        } else {
            return view("admin/manager/xiugai", ["manager" => $manager]);
        }

    }

//删除管理员
    public function del(Manager $manager)
    {
        $res = $manager->delete();
        if ($res) {
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect("admin/manager/login");
    }
}
