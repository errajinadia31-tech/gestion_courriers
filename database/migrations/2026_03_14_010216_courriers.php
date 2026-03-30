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
$table->text('objet');
    $table->enum('type', ['arrivee','depart']);

    $table->date('date');

    $table->string('type_document')->nullable();

    $table->string('expediteur')->nullable();

 
    $table->string('destinataire_externe')->nullable();
    $table->string('mode_envoi')->nullable();


    $table->string('file')->nullable();

    $table->enum('statut', ['En cours','Traité','Archivé'])->default('En cours');

    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('courriers');
    }
};