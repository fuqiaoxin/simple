<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create'],
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials,$request->has('remember'))){
            if(Auth::user()->activated){
                session()->flash('success',trans('webs.welcome_back'));
                return redirect()->intended(route('users.show',[Auth::user()]));
            }else{  // 未激活
                Auth::logout();
                session()->flash('warning',trans('webs.active_not'));
                return redirect('/');
            }


        }else{  // 登录失败
            session()->flash('danger',trans('auth.failed'));
            return redirect()->back();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success',trans('webs.logout'));
        return redirect('login');
    }
}
