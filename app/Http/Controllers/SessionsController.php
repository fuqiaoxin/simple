<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
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
            session()->flash('success',trans('webs.welcome_back'));
            return redirect()->route('users.show',[Auth::user()]);
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