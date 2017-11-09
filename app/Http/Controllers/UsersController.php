<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
class UsersController extends Controller
{
    //
    public function create(){

        return view('users.create');
    }

     public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    // public function index(Request $request)
    // {
    //     $this->validate($request,[
    //         'name' => 'require|max:50',
    //         'email' => 'require|email|unique:users|max:255',
    //         'password' => 'require',
    //     ]);
    //     return;
    //
    // }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success',trans('webs.welcome'));
        return redirect()->route('users.show',[$user]);
    }

    // public function edit($value='')
    // {
    //     # code...
    // }
    //
    // public function update($value='')
    // {
    //     # code...
    // }
    //
    // public function destroy(){
    //
    //
    // }
}
