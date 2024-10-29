<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Series;
use Illuminate\Http\Request;

class EpisodioController extends Controller
{
    public function buscaEpisodioSerie($id, $page = 1, $itemsPerPage = 10)
    {

        $offset = ($page - 1) * $itemsPerPage;
    
        // Buscar apenas os episódios com base na página atual e itens por página
        $episodios = Episode::where('series_id', $id)
            ->offset($offset)
            ->limit($itemsPerPage)
            ->get();
    
        return response()->json($episodios)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate') // HTTP 1.1.
            ->header('Pragma', 'no-cache') // HTTP 1.0.
            ->header('Expires', '0'); // Proxies.
    }
    
    
    public function buscaEpisodio($id)
    {
        $episodio = Episode::find($id);
        return response()->json($episodio); // Proxies.
    }
}
