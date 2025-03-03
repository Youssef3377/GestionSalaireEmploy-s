<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Exception;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(){
        $allConfigurations = Configuration ::latest()->paginate(2);
        return view('configuration.index',compact('allConfigurations'));
    }

    // Afficher le formulaire de création d'une config
 public function create()
 {
     return view('configuration.create');
 }

 // Sauvegarder une config dans la base de données
 public function store(Request $request)
 {
    $request->validate([
        'type' => 'required|string|max:255|unique:configurations,type',
        'value' => 'required|string|max:255|unique:configurations,value',
    ],
    [
        'type.required' => 'Le type de config est obligatoire.',
        'type.unique'   => 'Ce type existe déjà, veuillez en choisir un autre.',
        'type.max'      => 'Le type ne doit pas dépasser 255 caractères.',
        'value.required' => 'Le value de config est obligatoire.',
        'value.unique'   => 'Ce value existe déjà, veuillez en choisir un autre.',
        'value.max'      => 'Le value ne doit pas dépasser 255 caractères.',
    ]);
    try{


        Configuration::create($request->all());

        return redirect()->route('configuration.index')->with('success', 'configuration ajouté avec succès.');
    }catch(Exception $e){
        throw new Exception('Erreur lors de lenregistrements de la config');

    }




 }
  // Afficher un employé spécifique
  public function show($id)
  {
      $configurations = Configuration::findOrFail($id);
      return view('configuration.show', compact('configurations'));
  }

  // Afficher le formulaire d'édition
  public function edit($id)
  {


     $configurations = Configuration::findOrFail($id);  // Récupérer le département par ID
     return view('configuration.edit', compact('configurations'));  // Passer à la vue
 }


  // Mettre à jour un employé dans la base de données
  public function update(Request $request, $id)
  {
      $request->validate([
         'type' => 'required|string|max:255|unique:configurations,type,' . $id,
         'value' => 'required|string|max:255|unique:configurations,value,' . $id,

      ]);

      $configurations = Configuration::findOrFail($id);
      $configurations->update($request->all());

      return redirect()->route('configuration.index')->with('success', 'configuration mis à jour avec succès.');
  }

  // Supprimer un employé
  public function destroy($id)
  {
    Configuration::destroy($id);
      return redirect()->route('configuration.index')->with('success', 'configuration supprimé avec succès.');
  }

}
