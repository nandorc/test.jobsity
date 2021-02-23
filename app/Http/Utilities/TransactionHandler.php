<?php

namespace App\Http\Utilities;

use App\Models\TransactionLog;

class TransactionHandler
{
    const AMOUNT_INSTRUCTIONS = "You can write the transaction amount in one of the following ways.<br/>" .
        "- Write just the transaction amount (ex. 300)<br/>" .
        "- Write the transaction amount followed by the currency code (ex. 300 EUR)<br/>" .
        "- Use always . as decimal separator (ex. 300.53)";
    public static function reportSuccess(TransactionLog $transaction)
    {
        $transaction->status = 'A';
        $transaction->details = 'Transaction success';
        $transaction->save();
    }
    public static function reportFailure(TransactionLog $transaction, string $reason)
    {
        $transaction->status = 'R';
        $transaction->details = $reason;
        $transaction->save();
    }
    public static function createTransaction(string $uid, array $input, string $type, string $defaultCurrency)
    {
        $translog = new TransactionLog;
        $translog->type = $type;
        $translog->currency = ($input['code'] == null) ? $defaultCurrency : $input['code'];
        $translog->amount = $input['amount'];
        $translog->account = $uid;
        return $translog;
    }
    public static function parseInput(string $input)
    {
        $arr = array_values(array_filter(explode(' ', $input)));
        $amount = floatval($arr[0]);
        $code = isset($arr[1]) ? strtoupper($arr[1]) : null;
        return ['amount' => $amount, 'code' => $code];
    }
}
