<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = ['id','title',   'url_image', 'url_video' , 'episode_number', 'series_id'];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
