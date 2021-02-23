<?php

namespace App\Http\Middleware;

use App\Http\Utilities\ChatBotSessionHandler;
use Closure;
use Illuminate\Http\Request;

class ProcessChatbotMessage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        } else if ($module == 'logged') {
            $message = $this->cleanMessage($message);
            if ($message == 'deposit') return redirect()->route('account.transaction.deposit.init');
            else if ($message == 'withdraw') return redirect()->route('account.transaction.withdraw.init');
            else if ($message == 'balance') return redirect()->route('account.balance');
            else if ($message == 'defaultcurrency') return redirect()->route('account.currency.select');
            else if ($message == 'convert') return redirect()->route('account.utilities.converter.init');
    }

}
