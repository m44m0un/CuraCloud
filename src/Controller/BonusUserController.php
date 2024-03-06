<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BonusUserController extends AbstractController
{
    #[Route('user/sorteduserbymail', name: 'app_sorteduser', methods: ['GET', 'POST'])]
    public function usersortbymail(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        $users = $userRepository->showUsersSortedByEmail($currentUser);

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }
    
}