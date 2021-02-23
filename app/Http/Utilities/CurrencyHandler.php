<?php

namespace App\Http\Utilities;

use Illuminate\Http\Request;

class CurrencyHandler
{
    private $apikey = 'f971dda78085e6fdfa8da5aa416f783d';
    private $endpoint = 'http://data.fixer.io/api/';
    private $latest = [];
    public function __construct(Request &$request)
    {
        if ($request->session()->has('currencyhandler')) {
            $this->latest = $request->session()->get('currencyhandler');
        } else {
            $latest = $this->getLatest();
            $this->latest = $latest;
            $request->session()->put('currencyhandler', $latest);
        }
    }
    public function isSupported(string $cod)
    {
        return isset($this->latest[$cod]);
    }
    private function getLatest()
    {
        $path = $this->endpoint . 'latest?access_key=' . $this->apikey;
        $response = @file_get_contents($path);
        $obj = json_decode($response, true);
        return $obj['rates'];
    }
}
