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

class RegisterController extends AbstractController
{

    #[Route('/api/register', name: 'create_post', methods: ['POST'])]
    public function createPost(EmailService $emailService, MailerInterface $mailer, Request $request, UserManager $userManager, TraitementRequete $traitementRequete, JsonResponseGenerator $jsonResponseGenerator)
    {
        
        $register = $traitementRequete->processRequest($request);
        $user = $userManager->createUser($register);

        // Envoyer un e-mail à team@devphantom
        $emailService->sendEmail(
            'abdoukarimcouliba@gmail.com','absrimka65@gmail.com',
            'Time for Symfony Mailer!','Sending emails is fun again!',
            '<p>Un poste a été créé!</p>'
        );

        return $jsonResponseGenerator->createSuccessResponse('User a ete cree avec succes', Response::HTTP_CREATED);
    }

}
