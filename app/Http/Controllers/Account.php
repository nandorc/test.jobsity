<?php

namespace App\Http\Controllers;

use App\Http\Utilities\ChatBotHandler;
use App\Http\Utilities\CurrencyHandler;
use App\Models\User;
use GrahamCampbell\ResultType\Result;
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
        else if ($request->session()->has('info')) $head = $request->session()->get('info');
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
    public function balance(Request $request)
    {
        $dbuser = User::where('uid', $request->session()->get('uid'))->first();
        $balance = $dbuser->balance / 100;
        $request->session()->flash('info', "Your current balance reports $balance $dbuser->currency");
        return redirect()->route('account.init');
    }
    public function selectCurrency(Request $request)
    {
        $request->session()->put('module', 'defaultcurrency');
        $request->session()->flash('nextroute', 'account.currency.update');
        $msg = "Let's change your default currency!<br>" .
            "Write the new currency code";
        return ChatBotHandler::botResponse($msg);
    }
    public function updateCurrency(Request $request)
    {
        $message = strtoupper(ChatBotHandler::clean($request->old('message')));
        $curhandler = new CurrencyHandler($request);
        if ($curhandler->isSupported($message)) {
            $dbuser = User::where('uid', $request->session()->get('uid'))->first();
            $balance = $dbuser->balance / 100;
            $dbuser->balance = $curhandler->convert($dbuser->currency, $message, $balance) * 100;
            $dbuser->currency = $message;
            $dbuser->save();
            $request->session()->flash('info', "Transaction success!");
            return redirect()->route('account.init');
        } else {
            $request->session()->flash('nextroute', 'account.currency.update');
            $msg = "I can't handle that code :/<br/>" .
                "Let's try again. If you need some help, you could look at this " .
                "<a href=\"https://docs.1010data.com/1010dataUsersGuideV10/DataTypesAndFormats/currencyUnitCodes.html\" target=\"_blank\">" .
                "currency codes</a>";
            return ChatBotHandler::botResponse($msg);
        }
    }
    public function logout(Request $request)
    {
        //var_dump('En account.logout');
        $request->session()->forget('uid');
        return ChatBotHandler::redirResponse();
    }
}
