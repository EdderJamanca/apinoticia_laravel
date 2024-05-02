<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticiaRequest;
use App\Http\Controllers\Api\ApiController;

class NoticiaController extends ApiController
{
    public function listado(Request $request):JsonResponse
    {
        $idcategorias = explode(',', $request->idcategoria);
        // dd($idcategorias);

        $noticias = Noticia::select("NoticiaId","CategoriaId","Titulo","Resumen","Img","Contenido","Calificacion","Nom_Autor")
                    ->where("Calificacion",$request->calificacion)
                    ->whereIn("CategoriaId",$idcategorias)
                    ->get();

        return $this->successResponse($noticias);
    }

    public function Register(NoticiaRequest $request):JsonResponse
    {
        // dd($request);
        $noticiaActual =new Noticia();


         $noticiaActual -> CategoriaId=$request->CategoriaId;
         $noticiaActual -> Titulo=$request->Titulo;
         $noticiaActual -> Resumen=$request->Resumen;
         $noticiaActual -> Img=$request->Img;
         $noticiaActual -> Contenido=$request->Contenido;
         $noticiaActual -> Calificacion=$request->Calificacion;
         $noticiaActual -> Nom_Autor=$request->Nom_Autor;

         try{
             $noticiaActual->save();
            return $this->showMessage("Se registro exitosamente.");
         }catch (\Exception $e) {
            throw new Exception(
                'Error al registrar',
                Response::HTTP_BAD_REQUEST
            );
        }

    }
    public function eliminar(int $idnoticia):JsonResponse
    {

        try{

            $noticiaActual=Noticia::findOrFail($idnoticia);
            $noticiaActual->delete();

            return $this->showMessage("La noticia se elimino exitosamente.");
        } catch (\Exception $e) {
            throw new Exception(
                'Error al eliminar la noticia',
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
