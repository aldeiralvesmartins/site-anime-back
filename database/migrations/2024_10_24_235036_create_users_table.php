<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 /**
     * Tabela 'users'
     * Esta tabela armazena as informações dos usuários que utilizam a plataforma,
     * como nome, e-mail, senha e o plano de assinatura vinculado.
     */
    public function up()
    {
        Schema::create('user_animes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do usuário
            $table->string('email')->unique(); // E-mail único do usuário
            $table->string('password'); // Senha criptografada
            $table->foreignId('subscription_plan_id')->constrained()->onDelete('cascade'); // Relacionamento com plano de assinatura
            $table->timestamps(); // Colunas 'created_at' e 'updated_at'
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_animes');
    }
};
