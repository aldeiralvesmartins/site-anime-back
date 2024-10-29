<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Categorias principais
        $categories = [
            ['id' => 1, 'name' => 'Anime'],
            ['id' => 2, 'name' => 'Gênero'],
            ['id' => 3, 'name' => 'Filmes']
        ];

        // Inserindo categorias principais
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'id' => $category['id'],
                'name' => $category['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Subcategorias para cada categoria
        $subCategories = [
            ['category_id' => 1, 'name' => 'Aleatório'],
            ['category_id' => 1, 'name' => 'Em lançamento'],
            ['category_id' => 1, 'name' => 'Atualizados'],
            ['category_id' => 1, 'name' => 'Top Animes'],
            ['category_id' => 1, 'name' => 'Legendados'],
            ['category_id' => 1, 'name' => 'Dublados'],
            ['category_id' => 1, 'name' => 'Calendário'],
            ['category_id' => 2, 'name' => 'Ação'],
            ['category_id' => 2, 'name' => 'Mecha'],
            ['category_id' => 2, 'name' => 'Artes Marciais'],
            ['category_id' => 2, 'name' => 'Mistério'],
            ['category_id' => 2, 'name' => 'Aventura'],
            ['category_id' => 2, 'name' => 'Militar'],
            ['category_id' => 2, 'name' => 'Comédia'],
            ['category_id' => 2, 'name' => 'Musical'],
            ['category_id' => 2, 'name' => 'Demônios'],
            ['category_id' => 2, 'name' => 'Paródia'],
            ['category_id' => 2, 'name' => 'Drama'],
            ['category_id' => 2, 'name' => 'Psicológico'],
            ['category_id' => 2, 'name' => 'Ecchi'],
            ['category_id' => 2, 'name' => 'Romance'],
            ['category_id' => 2, 'name' => 'Espaço'],
            ['category_id' => 2, 'name' => 'Seinen'],
            ['category_id' => 2, 'name' => 'Esporte'],
            ['category_id' => 2, 'name' => 'Shoujo-ai'],
            ['category_id' => 2, 'name' => 'Fantasia'],
            ['category_id' => 2, 'name' => 'Shounen'],
            ['category_id' => 2, 'name' => 'Ficção Científica'],
            ['category_id' => 2, 'name' => 'Slice of Life'],
            ['category_id' => 2, 'name' => 'Harém'],
            ['category_id' => 2, 'name' => 'Sobrenatural'],
            ['category_id' => 2, 'name' => 'Horror'],
            ['category_id' => 2, 'name' => 'Suspense'],
            ['category_id' => 2, 'name' => 'Jogos'],
            ['category_id' => 2, 'name' => 'Superpoder'],
            ['category_id' => 2, 'name' => 'Josei'],
            ['category_id' => 2, 'name' => 'Vampiros'],
            ['category_id' => 2, 'name' => 'Magia'],
            ['category_id' => 2, 'name' => 'Vida Escolar'],
            ['category_id' => 3, 'name' => 'Legendados'],
            ['category_id' => 3, 'name' => 'Dublados']
        ];

        // Inserindo subcategorias
        foreach ($subCategories as $subCategory) {
            DB::table('sub_categories')->insert([
                'category_id' => $subCategory['category_id'],
                'name' => $subCategory['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
