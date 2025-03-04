<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    // Nom de la table (optionnel, car Laravel utilise automatiquement 'employers' au pluriel)
    protected $table = 'employers';

      // Clé primaire (optionnel, car Laravel utilise 'id' par défaut)
      protected $primaryKey = 'id';

   // Autoriser uniquement ces champs pour l'assignation de masse
   protected $fillable = ['nom', 'prenom', 'email', 'contact', 'departement_id', 'montant_journalier'];

   // Relation avec le modèle Departement (Un employé appartient à un département)
   public function departement()
   {
       return $this->belongsTo(Departement::class);
   }

    // Définir la relation One-to-Many (Un employeur peut avoir plusieurs paiements)
    public function payements()
    {
        return $this->hasMany(Payement::class);
    }
}
