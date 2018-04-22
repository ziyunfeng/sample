<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SessionsController extends Controller
{

    public function __construct ()
    {
        $this->middleware ('guest', [
            'only'  =>  ['create']
        ]);
    }

    public function create() {

        return view ('sessions.create');
    }

    public function store(Request $request) {

        $validate = $this->validate ($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt($validate, $request->has ('remember'))) {

            if(Auth::user ()->activated) {
                session ()->flash ('success', '欢迎回来！');
                return redirect ()->intended (route ('user.show', [Auth::user()]));
            } else {
                Auth::logout ();
                session ()->flash ('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect ('/');
            }


        } else {
            session ()->flash ('danger', '很抱歉,您的邮箱和密码不匹配');
            return redirect()->back();
        }

    }

    public function destroy(){
        Auth::logout ();
        session ()->flash ('success','您已成功退出登录');
        return redirect ('login');
    }


}
