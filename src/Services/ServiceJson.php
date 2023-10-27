<?php
    
    namespace App\Services;

    use App\Entity\Register;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseGenerator
{   
    public function createSuccessResponse($message, $statusCode = Response::HTTP_OK)
    {
        return new JsonResponse(['message' => $message], $statusCode);
    }
}
