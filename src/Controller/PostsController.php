<?php

namespace App\Controller;

use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostsController extends AbstractController
{
    #[Route('/api/post', name: 'app_posts')]
    public function create(
        Request $request,
        MailerInterface $mailer,
        ValidatorInterface $validator,
        EntityManagerInterface $manager
    )

    {
        $postData = json_decode($request->getContent(), true);

        $post = new Posts(); // Créez une instance de la classe Posts
        $post->setTitre($postData['titre']); // Utilisez $postData pour définir les propriétés
        $post->setContenu($postData['contenu']);
        $post->setAuteur($postData['auteur']);
        $post->setEmail($postData['email']);

        $violations = $validator->validate($post);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            return new JsonResponse(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Envoyez un e-mail à team@devphantom pour informer de la création du post
        $email = (new Email())
            ->from($post->getAuteur())
            ->to($post->getEmail())
            ->subject($post->getTitre())
            ->text($post->getContenu());

        $mailer->send($email);
        $manager->persist($post);
        $manager->flush();
        // Répondez avec une réponse JSON pour indiquer le succès
        return new JsonResponse(['message' => 'Post cree avec succes']);
    }
}
