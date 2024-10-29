<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela 'payments'
     * Esta tabela armazena os pagamentos realizados pelos usuários,
     * com informações como o método de pagamento e o plano de assinatura escolhido.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_anime_id')->constrained()->onDelete('cascade'); // Relaciona com o usuário
            $table->decimal('amount', 8, 2); // Valor pago
            $table->string('payment_method'); // Método de pagamento (ex: Cartão, PayPal)
            $table->date('payment_date'); // Data do pagamento
            $table->foreignId('subscription_plan_id')->constrained()->onDelete('cascade'); // Relaciona com o plano de assinatura
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
