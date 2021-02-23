<?php

namespace App\Http\Controllers\Utilities;

use App\Http\Controllers\Controller;
use App\Http\Utilities\ChatBotHandler;
use App\Http\Utilities\CurrencyHandler;
use Illuminate\Http\Request;

class Converter extends Controller
{
    public function init(Request $request)
    {
        $request->session()->put('module', 'converter');
        $request->session()->flash('nextroute', 'account.utilities.converter.convert');
        $msg = "Let's make some conversions!<br>" .
            "To make a conversion, you have to write your input in the following way<br/>" .
            "[AmountToConvert] [CurrencyCode] > [DestinyCurrencyCode]<br/>" .
            "Ex.<br/>" .
            "300 USD > EUR<br/>" .
            "It converts 300 USD to EUR<br/>" .
            "Remember to use always . as decimal separator (ex. 300.53)";
        return ChatBotHandler::botResponse($msg);
    }
    public function convert(Request $request)
    {
        $data = $this->parseInput($request->old('message'));
        $currhandler = new CurrencyHandler($request);
        $aresupported = $currhandler->isSupported($data['fromCode']) && $currhandler->isSupported($data['toCode']);
        if (!$aresupported) {
            $request->session()->flash('error', "One or both currency codes are not supported.");
        } else {
            $result = $currhandler->convert($data['fromCode'], $data['toCode'], $data['amount']);
            $msg = "Conversion done!<br/>" . $data['amount'] . ' ' . $data['fromCode'] . ' = ' . $result . ' ' . $data['toCode'];
            $request->session()->flash('info', $msg);
        }
        return redirect()->route('account.init');
    }
    private function parseInput(string $input)
    {
        $arr = explode('>', $input);
        $toCode = strtoupper(trim($arr[1]));
        $arr = array_values(array_filter(explode(' ', $arr[0])));
        $amount = floatval($arr[0]);
        $fromCode = isset($arr[1]) ? strtoupper($arr[1]) : null;
        return ['amount' => $amount, 'fromCode' => $fromCode, 'toCode' => $toCode];
    }
}
