<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $primaryKey ="NoticiaId";

    protected $fillable=[
        "CategoriaId",
        "Titulo",
        "Resumen",
        "Img",
        "Contenido",
        "Calificacion",
        "Nom_Autor"
    ];

    public $timestamps = false;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'CategoriaId');
    }

}
