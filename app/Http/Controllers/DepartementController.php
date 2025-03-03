<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{

 // Afficher la liste des employés
 public function index()
 {
     $departements = Departement::paginate(2);
     return view('departement.index', compact('departements'));
 }

 // Afficher le formulaire de création d'employé
 public function create()
 {
     return view('departement.create');
 }

 // Sauvegarder un employé dans la base de données
 public function store(Request $request)
 {
     $request->validate([
        'name' => 'required|string|max:255|unique:departements,name',
    ],
    [
        'name.required' => 'Le nom du département est obligatoire.',
        'name.unique'   => 'Ce département existe déjà, veuillez en choisir un autre.',
        'name.max'      => 'Le nom du département ne doit pas dépasser 255 caractères.',
    ]);


     Departement::create($request->only('name'));

     return redirect()->route('departement.index')->with('success', 'Département ajouté avec succès.');
 }

 // Afficher un employé spécifique
 public function show($id)
 {
     $departements = Departement::findOrFail($id);
     return view('departement.show', compact('departements'));
 }

 // Afficher le formulaire d'édition
 public function edit($id)
 {


    $departement = Departement::findOrFail($id);  // Récupérer le département par ID
    return view('departement.edit', compact('departement'));  // Passer à la vue
}


 // Mettre à jour un employé dans la base de données
 public function update(Request $request, $id)
 {
     $request->validate([
        'name' => 'required|string|max:255|unique:departements,name,' . $id,

     ]);

     $departements = Departement::findOrFail($id);
     $departements->update($request->all());

     return redirect()->route('departement.index')->with('success', 'Département mis à jour avec succès.');
 }

 // Supprimer un employé
 public function destroy($id)
 {
    Departement::destroy($id);
     return redirect()->route('departement.index')->with('success', 'Département supprimé avec succès.');
 }
}

