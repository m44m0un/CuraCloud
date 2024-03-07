<?php

namespace App\Controller;

use App\Entity\Prescription;
use App\Entity\Meds;
use App\Form\PrescriptionType;
use App\Form\MedsType;
use App\Repository\PrescriptionRepository;
use App\Repository\MedsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/')]
class PrescriptionController extends AbstractController
{
    #[Route('/admin/prescription/show', name: 'admin_prescription_index', methods: ['GET'])]
    public function index(PrescriptionRepository $prescriptionRepository): Response
    {
        return $this->render('prescription/index.html.twig', [
            'prescriptions' => $prescriptionRepository->findAll(),
        ]);
    }

    #[Route('/admin/prescriptions/new', name: 'admin_prescription_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prescription = new Prescription();
        $form = $this->createForm(PrescriptionType::class, $prescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($prescription);
            $entityManager->flush();

            return $this->redirectToRoute('admin_prescription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prescription/new.html.twig', [
            'prescription' => $prescription,
            'form' => $form,
        ]);
    }




    #[Route('/admin/prescriptions/{id}', name: 'admin_prescription_show', methods: ['GET'])]
    public function show(Prescription $prescription): Response
    {
        return $this->render('prescription/show.html.twig', [
            'prescription' => $prescription,
        ]);
    }

    #[Route('/admin/prescriptions/{id}/edit', name:'admin_prescription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prescription $prescription, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrescriptionType::class, $prescription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_prescription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prescription/edit.html.twig', [
            'prescription' => $prescription,
            'form' => $form,
        ]);
    }

    #[Route('/admin/prescriptions/{id}', name: 'admin_prescription_delete', methods: ['POST'])]
    public function delete(Request $request, Prescription $prescription, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prescription->getId(), $request->request->get('_token'))) {
            $entityManager->remove($prescription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_prescription_index', [], Response::HTTP_SEE_OTHER);
    }
    
    

    #[Route('/user/prescriptions', name: 'user_prescription_index', methods: ['GET','POST'])]
public function userIndex(PrescriptionRepository $prescriptionRepository): Response
{
    return $this->render('prescription/indexf.html.twig', [
        'prescriptions' => $prescriptionRepository->findAll(),
    ]);
}
        
    
#[Route('/user/prescriptions/{id}', name: 'user_prescription_show', methods: ['GET'])]
public function userShow(Prescription $prescription): Response
    {
        return $this->render('prescription/showf.html.twig', [
            'prescription' => $prescription,
        ]);
    }



        #[Route('/user/map', name: 'user_map')]
public function userMap(): Response
{
    return $this->render('prescription/map.html.twig');
}


#[Route('/send_prescription/{id}', name: 'send_prescription')]
public function sendPrescription(Prescription $prescription, MailerInterface $mailer): Response
{
    // Render the prescription details template
    $content = $this->renderView('prescription/showf.html.twig', [
        'prescription' => $prescription,
    ]);

    // Create the email
    $email = (new Email())
        ->from('ahmedjebari022@gmail.com') // Replace with your email
        ->to('edelgardray@gmail.com') // Replace with recipient's email
        ->subject('Prescription Details')
        ->html($content);

    // Send the email
    $mailer->send($email);

   

    // Redirect back to the prescription details page
    return $this->redirectToRoute('user_prescription_show', ['id' => $prescription->getId()]);
}


}


