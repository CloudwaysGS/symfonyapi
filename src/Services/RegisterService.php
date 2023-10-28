<?php

// src/Service/RegisterService.php

namespace App\Services;

use App\Entity\Register;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterService
{
    private $serializer;
    private $validator;
    private $entityManager;

    public function __construct(
        MailerInterface $mailer,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    public function register($requestData): array
    {
        $register = $this->serializer->deserialize(json_encode($requestData), Register::class, 'json');

        $violations = $this->validator->validate($register);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            return ['errors' => $errors];
        }

        $this->entityManager->persist($register);
        $this->entityManager->flush();

        $user = $this->createUserFromRegister($register);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return ['message' => 'Enregistrement réussi'];
    }

    public function createUserFromRegister(Register $register)
    {
        $user = new User();
        $user->setUsername($register->getUsername());
        $user->setPassword($register->getPassword());
        $user->setRoles($register->getRole());
        $user->setRegister($register);

        return $user;
    }
}
