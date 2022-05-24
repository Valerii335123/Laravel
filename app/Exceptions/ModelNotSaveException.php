<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ModelNotSaveException
 * @package App\Exceptions
 */
class ModelNotSaveException extends Exception
{
    public function render($request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
                                    'message' => $this->getMessage()
                                ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
