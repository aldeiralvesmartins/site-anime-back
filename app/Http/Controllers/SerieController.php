<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function show($id)
    {
        $serie = Series::find($id);
        return response()->json($serie);
    }

    public function recomendado()
    {
        $series = Series::orderBy('score', 'asc')->orderBy('votos', 'asc')->inRandomOrder()->take(17)->get();
        return response()->json($series);
    }

    public function lancamento(Request $request)
    {
        $page = $request->input('page', 1); // Pega a página atual, padrão é 1
        $limit = 24; // Defina o limite de itens por página

        $series = Series::orderBy('ano', 'desc')
            ->skip(($page - 1) * $limit) // Pular os itens das páginas anteriores
            ->take($limit) // Pega o número de itens definido pelo limite
            ->get()
            ->shuffle();

        return response()->json($series);
    }


    public function buscaAnime(Request $request)
    {
        $searchString = $request->input('nome');
        $limt = $request->input('limit');
        $searchString = preg_replace('/[^a-zA-Z\s]+/', '', $searchString);
        $searchString = strtolower(trim($searchString));
        $searchTerms = explode(' ', $searchString);
        $query = Series::query();
        if (!empty($searchTerms)) {
            foreach ($searchTerms as $term) {
                $query->orWhereRaw('LOWER(title) LIKE ?', ['%' . $term . '%']);
            }
        }
        // if (!empty($limt)){
            // $series = $query->get();
        // } else {
            $series = $query->take(10)->get();
        // }
        
        return response()->json($series);
    }
    
}
