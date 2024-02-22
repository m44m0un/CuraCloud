<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class AppointmentController extends AbstractController
{
    #[Route('/admin/appointment', name: 'admin_app_appointment_index', methods: ['GET'])]
    public function indexadmin(AppointmentRepository $appointmentRepository): Response
    {
        return $this->render('BackOffice/appointment/index.html.twig', [
            'appointments' => $appointmentRepository->findAll(),
        ]);
    }

    #[Route('admin/appointment/new', name: 'admin_app_appointment_new', methods: ['GET', 'POST'])]
    public function newadmin(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appointment);
            $entityManager->flush();

            return $this->redirectToRoute('admin_app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('BackOffice/appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('admin/appointment/{id}', name: 'admin_app_appointment_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        return $this->render('BackOffice/appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('admin/appointment/{id}/edit', name: 'admin_app_appointment_edit', methods: ['GET', 'POST'])]
    public function editadmin(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('BackOffice/appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('admin/appointment/{id}', name: 'admin_app_appointment_delete', methods: ['POST'])]
    public function deleteadmin(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('user/appointment/', name: 'user_app_appointment_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        return $this->render('FrontOffice/appointment/index.html.twig', [
            'appointments' => $appointmentRepository->findAll(),
        ]);
    }

    #[Route('user/appointment/new', name: 'user_app_appointment_new', methods: ['GET', 'POST'])]
    public function newuser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appointment);
            $entityManager->flush();

            return $this->redirectToRoute('user_app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('FrontOffice/appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('user/appointment/{id}', name: 'user_app_appointment_show', methods: ['GET'])]
    public function showuser(Appointment $appointment): Response
    {
        return $this->render('FrontOffice/appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('user/appointment/{id}/edit', name: 'user_app_appointment_edit', methods: ['GET', 'POST'])]
    public function edituser(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('FrontOffice/appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('user/appointment/{id}', name: 'user_app_appointment_delete', methods: ['POST'])]
    public function deleteuser(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }
}