<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Employer;
use App\Models\Payement;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayementController extends Controller
{
    public function index()
    {
        // Récupérer la date de paiement par défaut de la configuration
        $defaultPayementDateQuery = Configuration::where('type', 'PAYEMENT_DATE')->first();

        // Si la configuration n'existe pas, définir un comportement par défaut
        if (!$defaultPayementDateQuery) {
            // Définir une valeur par défaut pour $convertedPayementDate, par exemple le 1er du mois
            $convertedPayementDate = 1;
        } else {
            $defaultPayementDate = $defaultPayementDateQuery->value;
            $convertedPayementDate = intval($defaultPayementDate);
        }

        // Récupérer le jour actuel
        $today = date('d');

        // Vérifier si aujourd'hui est un jour de paiement
        $isPayementday = $today == $convertedPayementDate;

        // Récupérer la liste des paiements (avec pagination)
        $payements = Payement::latest()->orderBy('id', 'desc')->paginate(10);

        // Retourner la vue avec les données
        return view('payement.index', compact('payements', 'isPayementday'));
    }

    public function initPayement()
    {
        // Définir la langue en français pour les dates
        Carbon::setLocale('fr');

        // Obtenir le mois et l'année actuels
        $currentMonth = strtoupper(Carbon::now()->translatedFormat('F')); // Mois en majuscule
        $currentYear = Carbon::now()->format('Y'); // Année en 4 chiffres

        // Simuler des paiements pour les employeurs qui n'ont pas encore été payés ce mois
        $employers = Employer::whereDoesntHave('payements', function ($query) use ($currentMonth, $currentYear) {
            $query->where('month', $currentMonth)
                  ->where('year', $currentYear)
                  ->where('status', 'SUCCES');
        })->get();

        // Si tous les employeurs ont déjà été payés
        if ($employers->count() == 0) {
            return redirect()->back()->with('error', 'Tous vos employeurs ont déjà été payés pour ce mois de ' . $currentMonth);
        }

        // Effectuer le paiement pour chaque employeur
        foreach ($employers as $employer) {
            $aEtePyer = $employer->payements()->where('month', '=', $currentMonth)
                                              ->where('year', '=', $currentYear)
                                              ->exists();
            if (!$aEtePyer) {
                $salaire = $employer->montant_journalier * 31; // Salaire pour le mois
                $payement = new Payement([
                    'reference' => strtoupper(Str::random(10)),
                    'employer_id' => $employer->id,
                    'amount' => $salaire,
                    'lunch_date' => now(),
                    'done_time' => now(),
                    'status' => 'SUCCES',
                    'month' => $currentMonth,
                    'year' => $currentYear,
                ]);
                $payement->save();
            }
        }

        // Retourner à la page précédente avec un message de succès
        return redirect()->back()->with('success', 'Paiement des employeurs effectué pour le mois de ' . $currentMonth);
    }
}
