<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreateUserController extends AbstractController
{
    #[Route('/create/{email}', name: 'app_creat_user')]
    public function createUser(string $email, UserRepository $userRepository): Response
    {
        $user = new User();
        $user->setEmail($email);
        $user->setIsPremium(false);
        $userRepository->save($user, true);

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'is_premium' => $user->isPremium(),
        ]);
    }
}
