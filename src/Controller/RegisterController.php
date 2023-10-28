<?php

namespace App\Controller;

use App\Services\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class RegisterController extends AbstractController
{

    private $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    #[Route('/api/register', name: 'create_post', methods: ['POST'])]
    public function createPost(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $result = $this->registerService->register($data);

        if (isset($result['errors'])) {
            return new JsonResponse($result, JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($result, JsonResponse::HTTP_CREATED);
    }

}
