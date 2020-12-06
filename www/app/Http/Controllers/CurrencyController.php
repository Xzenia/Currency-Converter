<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::select('name', 'rate')->get();
        $currencies_json = json_encode($currencies);
        return view('index', compact('currencies', 'currencies_json'));
    }

    public function updateRates()
    {
      $url = "https://api.exchangeratesapi.io/latest?base=USD";
      $currencies = [];
      try {
          $response = file_get_contents($url);
          $currencies = json_decode($response,true);
      } catch (\Exception $exception) {
          return $exception;
      }

      foreach ($currencies['rates'] as $key => $currency) {
          $newEntry = [
              'name'  => $key,
              'rate'  => $currency
          ];
          Currency::updateOrCreate($newEntry);
      }

      return "Currency rates updated!";
    }
}
