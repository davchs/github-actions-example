<?php

namespace App\Controller;

use App\Form\TogglePremiumFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class UserPremiumController extends AbstractController
{
    #[Route('/user/{id}', name: 'app_user_toggle_premium')]
    public function togglePremium(Request $request, string $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find(Uuid::fromString($id));

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(TogglePremiumFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->togglePremiumStatus();
            $userRepository->save($user, true);
            $user->isPremium() ? $this->addFlash('success', 'User is now premium.') : $this->addFlash('success', 'User is no longer premium.');

            return $this->redirectToRoute('app_user_toggle_premium', ['id' => $user->getId()]);
        }

        return $this->render('user/form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
