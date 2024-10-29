<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 /**
     * Tabela 'subscription_plans'
     * Esta tabela armazena os diferentes tipos de planos de assinatura oferecidos pela plataforma,
     * incluindo preço, número máximo de telas e opções de qualidade HD/Ultra HD.
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do plano de assinatura (ex: Básico, Padrão, Premium)
            $table->decimal('price', 8, 2); // Preço do plano
            $table->integer('max_screens'); // Número máximo de telas permitidas
            $table->boolean('hd_available')->default(false); // Se o plano inclui HD
            $table->boolean('ultra_hd_available')->default(false); // Se o plano inclui Ultra HD
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
};
