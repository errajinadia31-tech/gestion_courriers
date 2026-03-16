<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courriers', function (Blueprint $table) {
            $table->id('id_courrier');
            $table->string('reference');
            $table->string('objet');
            $table->enum('type', ['Entrant','Sortant','Interne']);
            $table->date('date_envoi')->nullable();
            $table->date('date_reception')->nullable();
            $table->enum('statut', ['En cours','Traité','Archivé']);
        $table->string('image')->nullable()->change();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courriers');
    }
};