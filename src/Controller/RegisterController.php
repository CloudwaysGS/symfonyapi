<?php

namespace App\Controller;

use App\Entity\Register;
use App\Entity\User;
use App\Form\RegisterType;
use App\Services\EmailService;
use App\Services\JsonResponseGenerator;
use App\Services\TraitementRequete;
use App\Services\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\SerializerInterface;

class RegisterController extends AbstractController
{

    #[Route('/api/register', name: 'create_post', methods: ['POST'])]
    public function createPost(
        EmailService $emailService,
        MailerInterface $mailer,
        Request $request,
        UserManager $userManager,
        TraitementRequete $traitementRequete,
        JsonResponseGenerator $jsonResponseGenerator,
        SerializerInterface $serializer
    ) {
        $register = $traitementRequete->processRequest($request);
        $user = $userManager->createUser($register);

        // Envoyer un e-mail à team@devphantom
        $emailService->sendEmail(
            'abdoukarimcouliba@gmail.com',
            'absrimka65@gmail.com',
            'Time for Symfony Mailer!',
            'Sending emails is fun again!',
            '<p>Un poste a été créé!</p>'
        );
        // Serialize the $register object with the appropriate serialization group
        $json = $serializer->serialize($register, 'json', ['groups' => ['register:write']]);

        $data = [
            'register' => json_decode($json, true), // Convert the JSON string to an array
        ];
        return $jsonResponseGenerator->createSuccessResponse('Success', Response::HTTP_CREATED, $data);
    }
}
