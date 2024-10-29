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
        $series = Series::orderBy('score', 'asc')->orderBy('votos', 'asc')->inRandomOrder()->take(10)->get();
        return response()->json($series);
    }

    public function lancamento(Request $request)
    {
        $page = $request->input('page', 1); // Pega a página atual, padrão é 1
        $limit = 20; // Defina o limite de itens por página

        $series = Series::orderBy('ano', 'asc')
            ->skip(($page - 1) * $limit) // Pular os itens das páginas anteriores
            ->take($limit) // Pega o número de itens definido pelo limite
            ->get()
            ->shuffle();

        return response()->json($series);
    }


    public function buscaAnime(Request $request)
    {
        $searchString = $request->input('nome');
        $query = Series::query();
        if (!empty($searchString)) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($searchString) . '%']);
        }
        $series = $query->take(3)->get();
        return response()->json($series);
    }
}
