<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationForm2Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user1 = new User();
        $user2 = new User();
        $form1 = $this->createForm(RegistrationFormType::class, $user1);
        $form2 = $this->createForm(RegistrationForm2Type::class, $user2);
        $form1->handleRequest($request);
        $form2->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $user1->setInscriptionDate(new \DateTime());
            // encode the plain password
            $user1->setPassword(
                $userPasswordHasher->hashPassword(
                    $user1,
                    $form1->get('plainPassword')->getData()
                )
            );
            $user1->setRoles(['ROLE_PATIENT']);
            $entityManager->persist($user1);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        else if ($form2->isSubmitted() && $form2->isValid()) {
            $user2->setInscriptionDate(new \DateTime());
            // encode the plain password
            $user2->setPassword(
                $userPasswordHasher->hashPassword(
                    $user2,
                    $form2->get('plainPassword')->getData()
                )
            );
            $user2->setRoles(['ROLE_DOCTOR']);
            $entityManager->persist($user2);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form1->createView(),
            'registrationForm2' => $form2->createView(),
        ]);
    }
}
