<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payements', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade'); // Clé étrangère correcte
            $table->decimal('amount', 10, 2); // Stocker les montants en décimal
            $table->dateTime('lunch_date'); // Correction du nom
            $table->dateTime('done_time')->nullable(); // Nullable si pas encore payé
            $table->enum('status', ['SUCCES', 'FAILLED'])->default('SUCCES');
            $table->enum('month', [
                'JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN',
                'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE'
            ]);
            $table->string('year');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payements');
    }
};
