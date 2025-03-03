<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use App\Models\Employer;
class EmployerController extends Controller
{

    // Afficher la liste des employés



    public function index()
    {
        $employers = Employer::paginate(4);
        return view('employer.index', compact('employers'));
    }

    // Afficher le formulaire de création d'employé
    public function create()
    {
        $departements = Departement::all();
        return view('employer.create',compact('departements'));
    }


    // Sauvegarder un employé dans la base de données
    public function store(Request $request)
    {
     $request->validate([
            'departement_id' => 'required|exists:departements,id',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:employers,email',
            'contact' => 'required|unique:employers,contact',
            'montant_journalier' => 'required',
        ],
        [
        'email.required' => 'Le mail est obligatoire.',
        'email.unique'   => 'Ce mail existe déjà, veuillez en choisir un autre.',
        'contact.required' => 'Le contact est obligatoire.',
        'contact.unique'   => 'Ce contact existe déjà, veuillez en choisir un autre.',
        'departement_id.required' =>'le deparement est obligatoire',
        'departement_id.unique' =>'le deparement existe deja',
        ]
    );

        Employer::create($request->all());

        return redirect()->route('employer.index')->with('success', 'Employer ajouté avec succès.');
    }

    // Afficher un employé spécifique
    public function show($id)
    {
        $employers = Employer::findOrFail($id);
        return view('employer.show', compact('employers'));
    }

    public function edit($id)
{
    // Récupérer l'employé par son ID
    $employer = Employer::findOrFail($id);

    // Récupérer les départements (si tu veux les afficher dans le formulaire)
    $departements = Departement::all();

    // Retourner la vue avec l'employé et les départements
    return view('employer.edit', compact('employer', 'departements'));
}

    // Mettre à jour un employé dans la base de données
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:employers,email,' . $id,
            'contact' => 'required',

        ]);

        $employer = Employer::findOrFail($id);
        $employer->update($request->all());

        return redirect()->route('employer.index');
    }

    // Supprimer un employé
    public function destroy($id)
    {
        Employer::destroy($id);
        return redirect()->route('employer.index')->with('success', 'employer supprimé avec succès.');
    }
}


