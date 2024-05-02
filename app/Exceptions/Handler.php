<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ApiHelper;
use App\Helpers\ValidationHelper;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

        /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


       /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|\Illuminate\Http\Response|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
          //  if (config('app.debug')) {
        //     dd($e);
        //     return parent::render($request, $e);
        // }
        try {
            if($e instanceof ValidationException){
                return $this->convertValidationExceptionToResponse($e, $request);
            }

            if ($e instanceof AuthenticationException) {
                return $this->errorResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
            }

            if ($e instanceof UnauthorizedException) {
                return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
            }

            if ($e instanceof ModelNotFoundException) {
                return $this->convertModelNotFoundExceptionToResponse($e);
            }

            if($e instanceof NotFoundHttpException){
                return $this->errorResponse(
                    'La ruta del servicio especificado no existe.',
                    $e->getStatusCode()
                );
            }

            if($e instanceof MethodNotAllowedHttpException){
                return $this->errorResponse(
                    'El método especificado en la petición no es válido',
                    Response::HTTP_METHOD_NOT_ALLOWED
                );
            }

            if($e instanceof QueryException){
                return $this->errorResponse(
                    $e->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            if ($e instanceof HttpException) {
                return $this->errorResponse($e->getMessage(), $e->getStatusCode());
            }

            return $this->errorResponse($e->getMessage(), $e->getCode());
        } catch (Exception $exc) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

        /**
     * Create a response object from the given validation exception.
     *
     * @param ValidationException $e
     * @param $request
     * @return JsonResponse|\Illuminate\Http\Response|Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request): JsonResponse|\Illuminate\Http\Response|Response
    {
        $errors = ValidationHelper::formatErrors($e->validator->errors()->getMessages());

        return $this->errorResponse(
            'Validation error.',
            Response::HTTP_UNPROCESSABLE_ENTITY,
            [ApiHelper::IDX_STR_JSON_ERRORS => $errors]
        );
    }

    /**
     * @param ModelNotFoundException $e
     * @return JsonResponse
     */
    protected function convertModelNotFoundExceptionToResponse(ModelNotFoundException $e): JsonResponse
    {
        $modelName = strtolower(class_basename($e->getModel()));
        $ids = implode(", ", $e->getIds());

        $message = "No existe una instancia de %s con el id %s.";

        if (count($e->getIds()) > 1) {
            $message = "No existe una instancia de %s con los valores: %s.";
        }

        return $this->errorResponse(
            sprintf($message, $modelName, $ids),
            Response::HTTP_NOT_FOUND
        );
    }
}
