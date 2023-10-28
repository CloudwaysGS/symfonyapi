<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class PostsController extends AbstractController
{
    #[Route('/api/post', name: 'app_posts')]
    public function create(Request $request, MailerInterface $mailer)
    {
        $postData = json_decode($request->getContent(), true);

        // Envoyez un e-mail à team@devphantom pour informer de la création du post
        $email = (new Email())
            ->from('noreply@votresite.com')
            ->to('team@devphantom')
            ->subject('Nouveau post créé')
            ->text('Un nouveau post a été créé sur le site.');

        $mailer->send($email);

        // Répondez avec une réponse JSON pour indiquer le succès
        return new JsonResponse(['message' => 'Post cree avec succes']);
    }
}
