<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationForm2Type;
use App\Form\RegistrationForm3Type;
use App\Form\RegistrationForm4Type;
use App\Form\RegistrationForm5Type;
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
        $user3 = new User();
        $user4 = new User();
        $user5 = new User();
        $form1 = $this->createForm(RegistrationFormType::class, $user1);
        $form2 = $this->createForm(RegistrationForm2Type::class, $user2);
        $form3 = $this->createForm(RegistrationForm3Type::class, $user3);
        $form4 = $this->createForm(RegistrationForm4Type::class, $user4);
        $form5 = $this->createForm(RegistrationForm5Type::class, $user5);
        $form1->handleRequest($request);
        $form2->handleRequest($request);
        $form3->handleRequest($request);
        $form4->handleRequest($request);
        $form5->handleRequest($request);
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
        else if ($form3->isSubmitted() && $form3->isValid()) {
            $user3->setInscriptionDate(new \DateTime());
            // encode the plain password
            $user3->setPassword(
                $userPasswordHasher->hashPassword(
                    $user3,
                    $form3->get('plainPassword')->getData()
                )
            );
            $user3->setRoles(['ROLE_PHARMACY']);
            $entityManager->persist($user3);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }
        else if ($form4->isSubmitted() && $form4->isValid()) {
            $user4->setInscriptionDate(new \DateTime());
            // encode the plain password
            $user4->setPassword(
                $userPasswordHasher->hashPassword(
                    $user4,
                    $form4->get('plainPassword')->getData()
                )
            );
            $user4->setRoles(['ROLE_RADIOLOGY']);
            $entityManager->persist($user4);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }
        else if ($form5->isSubmitted() && $form5->isValid()) {
            $user5->setInscriptionDate(new \DateTime());
            // encode the plain password
            $user5->setPassword(
                $userPasswordHasher->hashPassword(
                    $user5,
                    $form5->get('plainPassword')->getData()
                )
            );
            $user5->setRoles(['ROLE_LAB']);
            $entityManager->persist($user5);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_logout');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form1->createView(),
            'registrationForm2' => $form2->createView(),
            'registrationForm3' => $form3->createView(),
            'registrationForm4' => $form4->createView(),
            'registrationForm5' => $form5->createView(),
        ]);
    }
}
