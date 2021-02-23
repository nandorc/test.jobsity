<?php

namespace App\Http\Controllers;

use App\Http\Utilities\ChatBotHandler;
use Illuminate\Http\Request;

class ChatBot extends Controller
{
    private $welcomeMessages = ["Welcome!", "Hello!", "Hi!", "Nice to meet you!"];
    public function welcome(Request $request)
    {
        //var_dump('En welcome');
        $request->session()->put('module', 'unlogged');
        $head = ChatBotHandler::randomMessage($this->welcomeMessages);
        if ($request->session()->has('error')) $head = $request->session()->get('error');
        $msg = $head . "<br/>" .
            "- Type SIGNIN if it's your first time here.<br/>" .
            "- Type LOGIN if you already have an account.";
        return ChatBotHandler::botResponse($msg);
    }
    public function message(Request $request)
    {
        //var_dump('En message');
        $module = $request->session()->get('module');
        $message = $request->input('message');
        $isoptionmodule = $module == 'unlogged' || $module == 'logged';
        if ($isoptionmodule) return $this->optionModule($module, $message);
        $nextroute = $request->session()->get('nextroute');
        if ($nextroute == 'login.check.password') $request->session()->keep(['_uid']);
        return redirect()->route($nextroute)->withInput($request->only('message'));
    }
    private function optionModule(string $module, string $message)
    {
        $option = ChatBotHandler::clean($message);
        if ($module == 'unlogged') return $this->unloggedModule($option);
        else return $this->loggedModule($option);
    }
    private function unloggedModule(string $option)
    {
        if ($option == 'login') return redirect()->route('login.init');
        else if ($option == 'signin') return redirect()->route('signin.init');
        else return redirect()->route('chatbot.welcome');
    }
    private function loggedModule(string $option)
    {
        if ($option == 'logout') return redirect()->route('account.logout');
    }
}
