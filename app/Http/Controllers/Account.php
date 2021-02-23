<?php

namespace App\Http\Controllers;

use App\Http\Utilities\ChatBotHandler;
use Illuminate\Http\Request;

class Account extends Controller
{
    private $greetMessages = ["Welcome Back!", "Hello again!", "Nice to see you again!"];
    public function init(Request $request)
    {
        //var_dump('En Account');
        $request->session()->put('module', 'logged');
        $head = ChatBotHandler::randomMessage($this->greetMessages);
        if ($request->session()->has('error')) $head = $request->session()->get('error');
        $msg = $head . "<br/>" .
            "What you want to do?<br/>" .
            "- Type DEPOSIT to increase your fortune.<br/>" .
            "- Type WITHDRAW to pay some fancy things.<br/>" .
            "- Type BALANCE to check how much money you got.<br/>" .
            "- Type DEFAULTCURRENCY to change your currency format.<br/>" .
            "- Type CONVERT to make a currency conversion.<br/>" .
            "- Type LOGOUT to exit.";
        return ChatBotHandler::botResponse($msg);
    }
    public function logout(Request $request)
    {
        //var_dump('En account.logout');
        $request->session()->forget('uid');
        return ChatBotHandler::redirResponse();
    }
}
