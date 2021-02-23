<?php

namespace App\Http\Controllers;

use App\Http\Utilities\ChatBotHandler;
use App\Models\User;
use Illuminate\Http\Request;

class Login extends Controller
{
    public function init(Request $request)
    {
        //var_dump('En login.init');
        $request->session()->put('module', 'login');
        $request->session()->flash('nextroute', 'login.check.user');
        $msg = "Let's Log in your account<br/>" .
            "Type your user name";
        return ChatBotHandler::botResponse($msg);
    }
    public function checkUser(Request $request)
    {
        //var_dump('En login.check.user');
        $message = $request->old('message');
        $userexists = User::where('uid', $message)->first() !== null;
        if ($userexists) {
            $request->session()->flash('_uid', $message);
            $request->session()->flash('nextroute', 'login.check.password');
            $msg = "Great $message!<br/> Type your password";
            return ChatBotHandler::botResponse($msg, 'password');
        } else {
            $request->session()->flash('error', "I can't find your user :(");
            return redirect()->route('chatbot.welcome');
        }
    }
    public function checkPassword(Request $request)
    {
        //var_dump('En login.check.password');
        $uid = $request->session()->get('_uid');
        $message = $request->old('message');
        $dbuser = User::where('uid', $uid)->first();
        if (password_verify($message, $dbuser->pwd)) {
            $request->session()->put('uid', $uid);
            return redirect()->route('account.init');
        } else {
            $request->session()->flash('error', "Password was wrong (-.-)!");
            return redirect()->route('chatbot.welcome');
        }
    }
}
