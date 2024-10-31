<?php

use App\Http\Controllers\EpisodioController;
use App\Http\Controllers\SerieController;
use App\Models\Category;
use App\Models\Episode;
use App\Models\Series;
use App\Models\Url;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/teste', function () {
    debug('teste');
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::post('/', 'AuthController@auth');
    Route::get('/verify', 'AuthController@verify');
});

Route::prefix('serie')->group(function () {
    Route::get('anime/busca-anime', [SerieController::class, 'buscaAnime']); // Rota com parâmetro depois
    Route::get('anime/lancamento', [SerieController::class, 'lancamento']); // Rota específica primeiro
    Route::get('anime/recomendado', [SerieController::class, 'recomendado']); // Rota específica primeiro
    Route::get('anime/{id}', [SerieController::class, 'show']); // Rota com parâmetro depois
});

Route::prefix('episodio')->group(function () {
    Route::get('anime/{serieId}', [EpisodioController::class, 'buscaEpisodioSerie']); // Rota com parâmetro depois
    Route::get('anime/buscaEpisodio/{id}', [EpisodioController::class, 'buscaEpisodio']); // Rota com parâmetro depois
});

Route::get('/out', function () {
    set_time_limit(120);
    $series = Series::where('id', '>=', 3451)->get();
    $dataSerie = [];

    foreach ($series as $index => $value) {
        $path = $value['img_src'];
        for ($i = 1; $i < 100; $i++) {
            $parts = explode('/', $path);
            $filename = end($parts);
   
     
            $animeTitle = strtolower(str_replace(['-large', '.webp', '.jpg'], '', pathinfo($filename, PATHINFO_FILENAME)));


            $urlImage = "https://animefire.plus/img/video/$animeTitle/$i.webp";
            $url = "https://animefire.plus/video/$animeTitle/$i";

            $jsonResponse = file_get_contents($url);

            if ($jsonResponse === FALSE) {
                break; // Para o loop for se a requisição falhar
            }

            $datas = json_decode($jsonResponse, true);

            if (!empty($datas['data']) && $datas['response']['status'] == '200') {
                preg_match('/<h1[^>]*>(.*?)<\/h1>/', $value['title'], $matches);
                if (isset($matches[1])) {
                    $h1Content = $matches[1];

                    Episode::create([
                        'series_id' => $value['id'],
                        'title' => "$h1Content - Episódio $i",
                        'episode_number' => $i,
                        'url_image' => $urlImage,
                        'url_video' => json_encode($datas['data'])

                    ]);
                } else {
                    echo "Nenhum elemento <h1> encontrado.";
                }
            } else {

                break; // Interrompe o loop for se a resposta não for '200'
            }
        }
    }
    return response()->json('tudo OK!');
});

Route::get('/ser5555ies', function () {
    set_time_limit(120);
    $animes = Url::all(); // Pega apenas o primeiro item
    $client = new Client();
    $data = [];

    if ($animes) {
        try {
            foreach ($animes as $anime) {

                $response = $client->request('GET', $anime->url);
                $html = $response->getBody()->getContents();
                $crawler = new Crawler($html);

                // Extrair a sinopse
                $sinopse = $crawler->filter('#body-content .divSinopse .spanAnimeInfo')->text();
                $tralerSrc = $crawler->filter('#iframe-trailer iframe')->attr('data-src');
                if (empty($tralerSrc)) {
                    $tralerSrc = $crawler->filter('#iframe-trailer iframe')->attr('data-src');
                }
                // Coletar dados para cada anime
                $crawler->filter('.divDivAnimeInfo')->each(function (Crawler $node) use ($anime, &$data, $sinopse, $tralerSrc) {
                    $title = $node->filter('.div_anime_names')->count() ?
                        $node->filter('.div_anime_names')->html() : 'Título não encontrado';

                    // URL da imagem a partir do data-src
                    $imgSrc = $node->filter('.sub_animepage_img img')->count() ?
                        $node->filter('.sub_animepage_img img')->attr('data-src') : 'Imagem não encontrada';

                    // Subcategorias
                    $subCategoria = $node->filter('.spanAnimeInfo.spanGenerosLink')->each(function (Crawler $subNode) {
                        return $subNode->text();
                    });

                    // Temporada
                    $temporada = $node->filter('.animeInfo span.spanAnimeInfo')->eq(0)->count() ?
                        $node->filter('.animeInfo span.spanAnimeInfo')->eq(0)->text() : 'Temporada não encontrada';

                    // Estúdios
                    $estudios = $node->filter('.animeInfo span.spanAnimeInfo')->eq(1)->count() ?
                        $node->filter('.animeInfo span.spanAnimeInfo')->eq(1)->text() : 'Estúdios não encontrados';

                    // Áudio
                    $audio = $node->filter('.animeInfo span.spanAnimeInfo')->eq(2)->count() ?
                        $node->filter('.animeInfo span.spanAnimeInfo')->eq(2)->text() : 'Áudio não encontrado';

                    // Episódios
                    $episodios = $node->filter('.animeInfo span.spanAnimeInfo')->eq(3)->count() ?
                        $node->filter('.animeInfo span.spanAnimeInfo')->eq(3)->text() : 'Episódios não encontrados';

                    // Status do Anime
                    $statusAnime = $node->filter('.animeInfo span.spanAnimeInfo')->eq(4)->count() ?
                        $node->filter('.animeInfo span.spanAnimeInfo')->eq(4)->text() : 'Status não encontrado';

                    // Dia de Lançamento
                    $diaLancamento = $node->filter('.animeInfo span.spanAnimeInfo')->eq(5)->count() ?
                        $node->filter('.animeInfo span.spanAnimeInfo')->eq(5)->text() : 'Dia de lançamento não encontrado';

                    $ano = $node->filter('.animeInfo span.spanAnimeInfo')->eq(6)->count() ?
                        $node->filter('.animeInfo span.spanAnimeInfo')->eq(6)->text() : 'Texto não encontrado';

                    // Score
                    $score = $node->filter('#anime_score')->count() ?
                        $node->filter('#anime_score')->text() : 'Score não encontrado';
                    // Verifica se o score é um número válido
                    $scoreNumeric = is_numeric($score) ? (float)$score : null; // Define como null ou trate conforme necessário

                    // Votos
                    $votos = $node->filter('#anime_votos')->count() ?
                        $node->filter('#anime_votos')->text() : 'Votos não encontrados';
                       
                    
                        // Cria a série
                        Series::create([
                        'title' => $title,
                        'img_src' => $imgSrc,
                        'score' => $scoreNumeric,
                        'votos' => $votos,
                        'sub_categoria' => implode(', ', $subCategoria),
                        'temporada' => $temporada,
                        'estudios' => $estudios,
                        'audio' => $audio,
                        'episodios' => $episodios,
                        'status_anime' => $statusAnime,
                        'dia_lancamento' => $diaLancamento,
                        'ano' => $ano,
                        'sinopse' => $sinopse,                     
                        'trailer_src' => $tralerSrc

                    ]);
                   
                    // Adiciona o anime ao array de dados
                   
                });
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'anime_url' => $anime->url]);
        }
    }

    return response()->json($data);
});

