<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference', 'employer_id', 'amount', 'lunch_date', 'done_time',
        'status', 'month', 'year'
    ];


    // Définir la relation inverse Many-to-One (Chaque paiement appartient à un employeur)
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
