<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;

class CategoriaController extends ApiController
{

    public function listado():JsonResponse
    {
        // dd('dsdsds');
        $resul=Categoria::select("idcategoria","Nom_Categoria")->get();

        return $this->successResponse($resul);
    }
}
