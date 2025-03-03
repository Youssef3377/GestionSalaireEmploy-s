<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Departement;
use App\Models\Employer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index (){
                // Compter le nombre total de départements
                $totalDepartements = Departement::all()->count();
                $totalEmployers = Employer::all()->count();
                $totalAdmin = User::all()->count();
//$AppName =Configuration ::where('type','APP_NAME')->first();
$defaultPayementDate =null;
$payementNotification = '';
$currentDate = Carbon::now()->day;
$defaultPayementDateQuery = Configuration::where('type','PAYEMENT_DATE')->first();

if($defaultPayementDateQuery){
    $defaultPayementDate = $defaultPayementDateQuery->value;
    $convertedPayementDate = intval($defaultPayementDate);
    if ($currentDate < $convertedPayementDate){
        $payementNotification = "le paiement doit avoir lieu le  "
           . $defaultPayementDate. " de ce mois";

    }
    else{
        $nextMonth = Carbon::now()->addMonth();
        $nextMonthName =$nextMonth->format('F');

        $payementNotification = "Le paiement doit avoir lieu le "
         . $defaultPayementDate . " du mois de " . $nextMonthName;
    }
}

                // Retourner la valeur à une vue ou à une réponse JSON
                return view('dashbord', compact('totalDepartements','totalEmployers','totalAdmin','payementNotification'));

    }
}
