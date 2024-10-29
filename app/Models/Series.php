<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'img_src',
        'score',
        'votos',
        'sub_categoria',
        'temporada',
        'estudios',
        'audio',
        'episodios',
        'status_anime',
        'dia_lancamento',
        'ano'
    ];

    
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
