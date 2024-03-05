<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserType2;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    
        #[Route('/', name: 'app_user', methods: ['GET', 'POST'])]
        public function user(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
        {
            // Handling the form submission for POST requests
            
                $user = new User();
                $form = $this->createForm(UserType::class, $user);
                $form->handleRequest($request);
        
                if ($form->isSubmitted() && $form->isValid()) {
                    $user->setInscriptionDate(new \DateTime());
                    $entityManager->persist($user);
                    $entityManager->flush();
        
                    return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
                }
        
                return $this->render('user/index.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                    'users' => $userRepository->findAll(),
                ]);
        }
    


    #[Route('/{id}', name: 'app_user_show', methods: ['GET', 'POST'])]
    public function show(User $user,Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType2::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('user/edit.html.twig', [
            
    //     ]);
    // }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
    }
}
