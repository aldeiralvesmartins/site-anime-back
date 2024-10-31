<?php

namespace Database\Seeders;

use App\Models\Series;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function Psy\debug;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           // Lê o conteúdo do arquivo JSON
           $json = File::get(database_path('data/series.json'));

           // Decodifica o JSON para um array associativo
           $data = json_decode($json, true);
   if (!empty($data['series'])) {
           foreach ($data['series'] as $series) {
               Series::create([
                   'title' => $series['title'],
                   'img_src' => $series['img_src'],
                   'score' => $series['score'],
                   'votos' => $series['votos'],
                   'sub_categoria' => $series['sub_categoria'],
                   'temporada' => $series['temporada'],
                   'estudios' => $series['estudios'],
                   'audio' => $series['audio'],
                   'episodios' => $series['episodios'],
                   'status_anime' => $series['status_anime'],
                   'dia_lancamento' => $series['dia_lancamento'],
                   'ano' => $series['ano'],
                   'sinopse' => $series['sinopse'],
                   'trailer_src' => $series['trailer_src'],
               ]);
           }
        }
    }
}
