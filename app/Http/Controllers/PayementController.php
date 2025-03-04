<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Payement;
use Carbon\Carbon;
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

    public function initPayement(){
      /*  $monthMapping = ['JANUARY'   => 'JANVIER',
    'FEBRUARY'  => 'FÉVRIER',
    'MARCH'     => 'MARS',
    'APRIL'     => 'AVRIL',
    'MAY'       => 'MAI',
    'JUNE'      => 'JUIN',
    'JULY'      => 'JUILLET',
    'AUGUST'    => 'AOÛT',
    'SEPTEMBER' => 'SEPTEMBRE',
    'OCTOBER'   => 'OCTOBRE',
    'NOVEMBER'  => 'NOVEMBRE',
    'DECEMBER'  => 'DÉCEMBRE',];
    //$currentMonth = strtoupper(Carbon::now()->formatLocalized('%B'));
   // dd($currentMonth);*/   // ancienne version obsolète

    Carbon::setLocale('fr'); // Définit la langue en français

    $currentMonth = strtoupper(Carbon::now()->translatedFormat('F')); // Obtenir le mois en majuscules

    $currentYear = Carbon::now()->format('Y'); // Année en 4 chiffres
    dd($currentYear);
        return view ('payement.init');
    }
}
