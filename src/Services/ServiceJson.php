<?php
    
    namespace App\Services;

    use App\Entity\Register;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseGenerator
{
    public function createSuccessResponse($message, $statusCode = Response::HTTP_OK, $data = [])
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return new JsonResponse($response, $statusCode);
    }
}
