<?php

namespace App\Http\Controllers;

use App\Profile;
use Auth;
use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function verify($token)
    {
    	$user = User::where('confirmation_token',$token)->first();

    	if(is_null($user))
    	{
    		flash('邮箱验证失败')->error();
    		return redirect('/register');
    	}

    	$user->is_active = 1;
    	$user->confirmation_token = str_random(40);
        $user->save();
    	flash('邮箱验证成功')->success();


    	Auth::login($user);
    	return redirect('/');
    }

    public function toVerify()
    {
        return view('user.verify');
    }
}
