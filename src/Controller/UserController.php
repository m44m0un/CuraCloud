<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserTypeExtended;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    
        #[Route('/', name: 'app_user', methods: ['GET', 'POST'])]
        public function user(Request $request, UserRepository $userRepository, NotificationRepository $notificationRepository, EntityManagerInterface $entityManager): Response
        {
            $currentUser = $this->getUser();
            $role = $request->query->get('role');
            $status = $request->query->get('status');
            $nbusers = $userRepository->countUsers();
            $nbbannedusers = $userRepository->countBannedUsers();
            $userspercent=$userRepository->getPercentageOfUsersCreatedInCurrentMonth();
            // $nbunverifieduser = $userRepository->countUnverifiedUsers();
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setInscriptionDate(new \DateTime());
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
            }

            $users = $userRepository->findAllUsersWithSpecificFieldsExceptCurrentUserAndRolesStatus($currentUser, $role, $status);
            $notification=$notificationRepository->showNotifSortedByCreationdate();
            return $this->render('user/index.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
                'users' => $users,
                'nbusers' => $nbusers,
                'nbbannedusers' => $nbbannedusers ,
                'userspercent' => $userspercent ,
                'notifications' => $notification
            ]);
        }


        #[Route('/{id}', name: 'app_user_show', methods: ['GET', 'POST'])]
        public function show(User $user,Request $request, EntityManagerInterface $entityManager): Response
        {
            $form = $this->createForm(UserTypeExtended::class, $user);
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
        
        #[Route('ban/{id}', name: 'admin_ban_user')]
        public function banUser($id, MailerInterface $mailer): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException('No user found for id '.$id);
            }

            $user->setIsBanned(true);
            $entityManager->flush();

            // do anything else you need here, like send an email

            $emailContent = $this->renderView('security/email_ban.html.twig');
            $email = (new Email())
            ->from('CuraCloud Bot <no-reply@curacloud.tn>')
            ->to($user->getEmail())//
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Alert!')
            ->text('....')
            ->html($emailContent);
            $mailer->send($email);

            return $this->redirectToRoute('app_user');
        }

        #[Route('unban/{id}', name: 'admin_unban_user')]
        public function unbanUser($id): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);

            if (!$user) {
                throw $this->createNotFoundException('No user found for id ' . $id);
            }
            $user->setIsBanned(False);

            $entityManager->flush();

            return $this->redirectToRoute('app_user');
        }

}
