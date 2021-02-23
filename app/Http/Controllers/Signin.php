<?php

namespace App\Http\Controllers;

use App\Http\Utilities\CurrencyHandler;
use App\Http\Utilities\ChatBotHandler;
use App\Models\User;
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
    public function checkUser(Request $request)
    {
        //var_dump('En signin.check.user');
        $message = $request->old('message');
        $userexists = User::where('uid', $message)->first() !== null;
        if ($userexists) {
            $request->session()->flash('error', "That user name is already taken :/");
            return redirect()->route('chatbot.welcome');
        } else {
            $request->session()->flash('_uid', $message);
            $request->session()->flash('nextroute', 'signin.check.password');
            $msg = "Nice! You got it!<br/>" .
                "Now it's time to set your password";
            return ChatBotHandler::botResponse($msg, 'password');
        }
    }
    public function checkPassword(Request $request)
    {
        //var_dump('En signin.check.password');
        $message = $request->old("message");
        $request->session()->keep(['_uid']);
        $request->session()->flash('_pwd', $message);
        $request->session()->flash('nextroute', 'signin.check.confirmation');
        $msg = "You're doing fantastic!<br/>" .
            "Now I need you to confirm your password";
        return ChatBotHandler::botResponse($msg, 'password');
    }
    public function checkConfirmation(Request $request)
    {
        //var_dump('En signin.check.confirmation');
        $pwd = $request->session()->get('_pwd');
        $message = $request->old('message');
        if ($pwd == $message) {
            $request->session()->keep(['_uid', '_pwd']);
            $request->session()->flash('nextroute', 'signin.set.currency');
            $msg = "Great!<br>" .
                "Finally, you must set your currency code";
            return ChatBotHandler::botResponse($msg);
        } else {
            $request->session()->flash('error', "Your confirmation password didn't match (¬.¬)");
            return redirect()->route('chatbot.welcome');
        }
    }
    public function setCurrency(Request $request)
    {
        //var_dump('En signin.set.currency');
        $message = strtoupper(ChatBotHandler::clean($request->old('message')));
        $curhandler = new CurrencyHandler($request);
        if ($curhandler->isSupported($message)) {
            $user = new User;
            $user->uid = $request->session()->get('_uid');
            $user->pwd = password_hash($request->session()->get('_pwd'), PASSWORD_DEFAULT);
            $user->currency = $message;
            $user->save();
            $request->session()->put('uid', $request->session()->get('_uid'));
            return redirect()->route('account.init');
        } else {
            $request->session()->keep(['_uid', '_pwd']);
            $request->session()->flash('nextroute', 'signin.set.currency');
            $msg = "I can't handle that code :/<br/>" .
                "Let's try again. If you need some help, you could look at this " .
                "<a href=\"https://docs.1010data.com/1010dataUsersGuideV10/DataTypesAndFormats/currencyUnitCodes.html\" target=\"_blank\">" .
                "currency codes</a>";
            return ChatBotHandler::botResponse($msg);
        }
    }
}
