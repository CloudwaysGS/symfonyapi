<?php
    
namespace App\Services;

use App\Entity\Register;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createUser(Register $register)
    {
        $user = new User();
        $user->setUsername($register->getUsername());
        $user->setPassword($register->getPassword());
        $user->setRoles($register->getRole());
        $user->setRegister($register);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}