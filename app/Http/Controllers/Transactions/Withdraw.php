<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Utilities\ChatBotHandler;
use App\Http\Utilities\CurrencyHandler;
use App\Http\Utilities\TransactionHandler;
use App\Models\User;
use Illuminate\Http\Request;

class Withdraw extends Controller
{
    public function init(Request $request)
    {
        //var_dump('En account.transaction.withdraw.init');
        $request->session()->put('module', 'withdraw');
        $request->session()->flash('nextroute', 'account.transaction.withdraw.check.amount');
        $msg = "How much money do you want to withdraw?<br/>" .
            TransactionHandler::AMOUNT_INSTRUCTIONS;
        return ChatBotHandler::botResponse($msg);
    }
    public function checkAmount(Request $request)
    {
        //var_dump('En account.transaction.deposit.check.amount');
        $dbuser = User::where('uid', $request->session()->get('uid'))->first();
        $input = TransactionHandler::parseInput($request->old('message'));
        $transaction = TransactionHandler::createTransaction($dbuser->uid, $input, 'withdraw', $dbuser->currency);
        $curhandler = new CurrencyHandler($request);
        if (!$curhandler->isSupported($transaction->currency)) {
            $error = "Transaction failed. Currency code not supported";
            TransactionHandler::reportFailure($transaction, $error);
            $request->session()->flash('error', $error);
        } else {
            $fixedAmount = $curhandler->convert($transaction->currency, $dbuser->currency, $transaction->amount) * 100;
            if ($fixedAmount > $dbuser->balance) {
                $error = "Transaction failed. Insufficient funds";
                TransactionHandler::reportFailure($transaction, $error);
                $request->session()->flash('error', $error);
            } else {
                $dbuser->balance -= $fixedAmount;
                $dbuser->save();
                TransactionHandler::reportSuccess($transaction);
                $request->session()->flash('info', "Transaction success!");
            }
        }
        return redirect()->route('account.init');
    }
}
