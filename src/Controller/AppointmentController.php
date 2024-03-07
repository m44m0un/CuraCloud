<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\UserRepository;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/')]
class AppointmentController extends AbstractController
{
    #[Route('/doctor/appointment', name: 'admin_app_appointment_index', methods: ['GET'])]
    public function indexadmin(AppointmentRepository $appointmentRepository): Response
    {
        return $this->render('BackOffice/appointment/index.html.twig', [
            'appointments' => $appointmentRepository->findAll(),
        ]);
    }

    #[Route('doctor/appointment/new', name: 'admin_app_appointment_new', methods: ['GET', 'POST'])]
    public function newadmin(Request $request, EntityManagerInterface $entityManager,AppointmentRepository $appointmentRepository ): Response
    {
        $appointment = new Appointment();

        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $startDate = $appointment->getStartDate();
            $endDate = $appointment->getEndDate();
        
            // Check for overlapping appointments
            $overlappingAppointments = $appointmentRepository->findOverlappingAppointments($startDate, $endDate);
            
            if (count($overlappingAppointments) > 0) {
                // Handle the error, for instance, by setting a flash message to inform the user
                $this->addFlash('error', 'An appointment is already scheduled within the selected time frame. Please choose a different time.');
            } else {
                // Proceed with saving the appointment if no overlap is found
                $entityManager->persist($appointment);
                $entityManager->flush();
        
                // Redirect after successful appointment creation
                return $this->redirectToRoute('user_app_appointment_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        

        return $this->renderForm('BackOffice/appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('doctor/appointment/{id}', name: 'admin_app_appointment_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        return $this->render('BackOffice/appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('doctor/appointment/{id}/edit', name: 'admin_app_appointment_edit', methods: ['GET', 'POST'])]
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

    #[Route('doctor/appointment/{id}', name: 'admin_app_appointment_delete', methods: ['POST'])]
    public function deleteadmin(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $appointment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/doctor/appointment/accept/{id}', name: 'appointment_accept')]
    public function accept(Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        $appointment->setStatus('accepted');
        $entityManager->flush();

        // You might want to return a redirect or a confirmation page here
        return $this->redirectToRoute('admin_app_appointment_index');
    }

    #[Route('/doctor/appointment/decline/{id}', name: 'appointment_decline')]
    public function decline(Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        $appointment->setStatus('declined');
        $entityManager->flush();

        // Similarly, redirect or show a page as confirmation
        return $this->redirectToRoute('admin_app_appointment_index');
    }




    #[Route('patient/appointment/', name: 'user_app_appointment_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        return $this->render('FrontOffice/appointment/index.html.twig', [
            'appointments' => $appointmentRepository->findAll(),
        ]);
    }

    #[Route('patient/appointment/new/{id_doctor}', name: 'user_app_appointment_new', methods: ['GET', 'POST'])]
public function newUser(Request $request, EntityManagerInterface $entityManager, AppointmentRepository $appointmentRepository, UserRepository $userRepository, $id_doctor): Response
{
    $appointment = new Appointment();
    $appointment->setStatus('pending');
    $doctor = $userRepository->find($id_doctor);
    $appointment->setIdDoctor($doctor); // Assuming this sets the doctor for the appointment

    $form = $this->createForm(AppointmentType::class, $appointment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $startDate = $appointment->getStartDate();
        $endDate = $appointment->getEndDate();

        $overlappingAppointments = $appointmentRepository->findOverlappingAppointments($startDate, $endDate);
        
        if (count($overlappingAppointments) > 0) {
            if ($request->isXmlHttpRequest()) {
                // Return an error JSON response for AJAX request
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'An appointment is already scheduled within the selected time frame. Please choose a different time.'
                ]);
            } else {
                // Handle the error for standard form submission
                $this->addFlash('error', 'An appointment is already scheduled within the selected time frame. Please choose a different time.');
            }
        } else {
            $entityManager->persist($appointment);
            $entityManager->flush();
            
            if ($request->isXmlHttpRequest()) {
                // Return a success JSON response for AJAX request
                return new JsonResponse([
                    'status' => 'success',
                    'redirectUrl' => $this->generateUrl('user_app_appointment_index'),
                ]);
            } else {
                // Handle the success for standard form submission
                $this->addFlash('success', 'The appointment has been successfully added.');
                return $this->redirectToRoute('user_app_appointment_index');
            }
        }
    }

    // If the form is not submitted, or it is not valid, render the form
    return $this->renderForm('FrontOffice/appointment/new.html.twig', [
        'appointment' => $appointment,
        'form' => $form,
    ]);
}

    #[Route('patient/appointment/{id}', name: 'user_app_appointment_show', methods: ['GET'])]
    public function showuser(Appointment $appointment): Response
    {
        return $this->render('FrontOffice/appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('patient/appointment/{id}/edit', name: 'user_app_appointment_edit', methods: ['GET', 'POST'])]
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

    #[Route('patient/appointment/{id}', name: 'user_app_appointment_delete', methods: ['POST'])]
    public function deleteuser(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $appointment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route(path: '/calendar', name: "admin_appointment_calendar", methods: ['GET'])]
    public function calendar(): Response
    {
        return $this->render('BackOffice/appointment/calendar.html.twig');
    }
    #[Route('/doctors/list', name: 'doctors_list')]
    public function doctorsList(UserRepository $userRepository, AppointmentRepository $appointmentRepository): Response
    {
        $doctors = $userRepository->findByRoleDoctor();
        $ratings = $appointmentRepository->findAverageRatingByDoctor();
    
        // Convert the ratings array into a key-value pair for easier access in Twig
        $ratingsMap = [];
        foreach ($ratings as $rating) {
            $ratingsMap[$rating['doctorId']] = $rating['averageRating'];
        }
    
        return $this->render('FrontOffice/appointment/Doctor.html.twig', [
            'doctors' => $doctors,
            'ratings' => $ratingsMap,
        ]);
    }

}
