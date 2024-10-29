<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela 'user_watch_history'
     * Esta tabela armazena o histórico de visualização de cada usuário,
     * incluindo o progresso (em %) de quanto já assistiu de um filme ou episódio de série.
     */
    public function up()
    {
        Schema::create('user_watch_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_anime_id')->constrained()->onDelete('cascade'); // Relaciona com o usuário
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Relaciona com o filme ou série
            $table->integer('progress')->default(0); // Progresso de visualização (em %)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_watch_history');
    }
};
