<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id(); // Identificador único da subcategoria
            $table->foreignId('category_id') // Referência à tabela de categorias
                ->constrained()
                ->onDelete('cascade'); // Se a categoria for excluída, as subcategorias também serão
            $table->string('name'); // Nome da subcategoria
            $table->timestamps(); // Timestamps para created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories'); // Remove a tabela se necessário
    }
};
