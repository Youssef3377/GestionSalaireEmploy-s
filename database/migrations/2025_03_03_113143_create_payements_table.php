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
            $table->string('reference');

            $table->unsignedBigInteger('employer_id');
            $table->foreign('employer_id')->references('id')->on('employers');
            $table->string('amount');
            $table->dateTime('lunch_date');
            $table->dateTime('done_time');
            $table->enum('status',['SUCCES','FAILLED'])->default('SUCCES');
            $table->enum('month',['JANVIER','FEVRIER','MARS',
            'AVRIL','MAI','JUIN','JUILLET','AOUT','SEPTEMBRE'
            ,'OCTOBRE','NOVEMBRE','DECEMBRE']);
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
