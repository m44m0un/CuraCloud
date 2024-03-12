<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Notification;
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
        $notif = new Notification();
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
                    $form1->get('password')->getData()
                )
            );
            $user1->setRoles(['ROLE_PATIENT']);
            $notif->setTitle("Welcome to our new Patient");
            $notif->setMessage($form1->get('firstName')->getData() . " " . $form1->get('lastName')->getData() . "has been added to the list of our patients");
            $entityManager->persist($notif);
            $entityManager->persist($user1);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        else if ($form2->isSubmitted() && $form2->isValid()) {
            // encode the plain password
            $user2->setPassword(
                $userPasswordHasher->hashPassword(
                    $user2,
                    $form2->get('password')->getData()
                )
            );
            $user2->setRoles(['ROLE_DOCTOR']);
            $notif->setTitle("Welcome to our new Doctor");
            $notif->setMessage($form1->get('firstName')->getData() . " " . $form1->get('lastName')->getData() . "has been added to the list of our doctors");
            $entityManager->persist($notif);
            $entityManager->persist($user2);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }
        else if ($form3->isSubmitted() && $form3->isValid()) {
            // encode the plain password
            $user3->setPassword(
                $userPasswordHasher->hashPassword(
                    $user3,
                    $form3->get('password')->getData()
                )
            );
            $user3->setRoles(['ROLE_PHARMACY']);
            $notif->setTitle("Welcome to a new Pharmacy");
            $notif->setMessage($form1->get('firstName')->getData() . "has been added to the list of our Pharmacies");
            $entityManager->persist($notif);
            $entityManager->persist($user3);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }
        else if ($form4->isSubmitted() && $form4->isValid()) {
            // encode the plain password
            $user4->setPassword(
                $userPasswordHasher->hashPassword(
                    $user4,
                    $form4->get('password')->getData()
                )
            );
            $user4->setRoles(['ROLE_RADIOLOGY']);
            $notif->setTitle("Welcome to a new Radiology Center");
            $notif->setMessage($form1->get('firstName')->getData() . "has been added to the list of our Radiology centers");
            $entityManager->persist($notif);
            $entityManager->persist($user4);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }
        else if ($form5->isSubmitted() && $form5->isValid()) {
            // encode the plain password
            $user5->setPassword(
                $userPasswordHasher->hashPassword(
                    $user5,
                    $form5->get('password')->getData()
                )
            );
            $user5->setRoles(['ROLE_LAB']);
            $notif->setTitle("Welcome to a new Laboratpry");
            $notif->setMessage($form1->get('firstName')->getData() . "has been added to the list of our Laboratories");
            $entityManager->persist($notif);
            $entityManager->persist($user5);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
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
