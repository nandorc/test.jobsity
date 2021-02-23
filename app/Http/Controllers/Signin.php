<?php

namespace App\Http\Controllers;

use App\Http\Utilities\ChatBotHandler;
use Illuminate\Http\Request;

class Signin extends Controller
{
    public function init(Request $request)
    {
        //var_dump('En signin.init');
        $request->session()->put('module', 'signin');
        $request->session()->flash('nextroute', 'signin.check.user');
        $msg = "Let's signup!<br/>" .
            "First you have to type your user name";
        return ChatBotHandler::botResponse($msg);
    }
}
