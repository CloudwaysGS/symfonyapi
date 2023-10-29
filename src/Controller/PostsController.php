<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Services\DataValidationService;
use App\Services\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PostsController extends AbstractController
{

    private $dataValidationService;
    private $emailService;
    private $entityManager;

    public function __construct(
        DataValidationService $dataValidationService,
        EmailService $emailService,
        EntityManagerInterface $entityManager
    ) {
        $this->dataValidationService = $dataValidationService;
        $this->emailService = $emailService;
        $this->entityManager = $entityManager;
    }
    #[Route('/api/post', name: 'app_posts')]
    public function create(
        Request $request,
        DataValidationService $dataValidationService,
        EmailService $emailService,
        EntityManagerInterface $manager
    ) {
        $postData = json_decode($request->getContent(), true);

        $post = new Posts(); // Créez une instance de la classe Posts
        $post->setTitre($postData['titre']);
        $post->setContenu($postData['contenu']);
        $post->setAuteur($postData['auteur']);
        $post->setEmail($postData['email']);

        $errors = $dataValidationService->validateData($post, $post);
        if ($errors !== null) {
            return new JsonResponse(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Envoyez un e-mail à team@devphantom pour informer de la création du post
        $emailService->sendEmail($post->getAuteur(), $post->getEmail(), $post->getTitre(), $post->getContenu());

        $manager->persist($post);
        $manager->flush();

        return new JsonResponse(['message' => 'Post créé avec succès']);
    }

}
