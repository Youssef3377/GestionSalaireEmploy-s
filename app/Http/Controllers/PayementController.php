<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Payement;
use Illuminate\Http\Request;

class PayementController extends Controller
{
    public function index (){
        $defaultPayementDateQuery = Configuration::where('type','PAYEMENT_DATE')->first();
        $defaultPayementDate = $defaultPayementDateQuery->value;
        $convertedPayementDate = intval($defaultPayementDate);
        $today = date('d');
      $isPayementday = false;
      if($today == $convertedPayementDate){
        $isPayementday = true;
      }
        $payements = Payement:: latest()->orderBy('id','desc')
        ->paginate('10');
        return view ('payement.index',compact('payements','isPayementday'));
    }
}
