<?php

namespace App\Controller;

use App\Entity\DiagnosticRequest;
use App\Form\DiagnosticRequestType;
use App\Repository\DiagnosticRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/diagnostic/request')]
class DiagnosticRequestController extends AbstractController
{
    #[Route('/', name: 'app_diagnostic_request_index', methods: ['GET'])]
    public function index(DiagnosticRequestRepository $diagnosticRequestRepository): Response
    {
        return $this->render('diagnostic_request/index.html.twig', [
            'diagnostic_requests' => $diagnosticRequestRepository->findAll(),
        ]);
    }
    //Afficher diagnostic pour medecin
    #[Route('/index2', name: 'app_diagnostic_request_index2', methods: ['GET'])]
    public function index2(DiagnosticRequestRepository $diagnosticRequestRepository): Response
    {
        return $this->render('diagnostic_request/index2.html.twig', [
            'diagnostic_requests' => $diagnosticRequestRepository->findAll(),
        ]);
    }

    //Fonction1 : ajouter une demande de diagnostic 
    #[Route('/new', name: 'app_diagnostic_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $diagnosticRequest = new DiagnosticRequest();
        //Récuperer la date automatiquement du Systéme 
        $diagnosticRequest->setCreationDate(new \DateTime()); 

        $form = $this->createForm(DiagnosticRequestType::class, $diagnosticRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($diagnosticRequest);
            $entityManager->flush();
           

            return $this->redirectToRoute('app_diagnostic_request_index2', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diagnostic_request/new.html.twig', [
            'diagnostic_request' => $diagnosticRequest,
            'form' => $form,
        ]);
    }

    //Fonction 2 : afficher diagnostic 
    #[Route('/{id}', name: 'app_diagnostic_request_show', methods: ['GET'])]
    public function show(DiagnosticRequest $diagnosticRequest): Response
    {
        return $this->render('diagnostic_request/show.html.twig', [
            'diagnostic_request' => $diagnosticRequest,
        ]);
    }

    //Fonction 3 : modifier diagnostic
    #[Route('/{id}/edit', name: 'app_diagnostic_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DiagnosticRequest $diagnosticRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DiagnosticRequestType::class, $diagnosticRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_diagnostic_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diagnostic_request/edit.html.twig', [
            'diagnostic_request' => $diagnosticRequest,
            'form' => $form,
        ]);
    }

    //Fonction 4: supprimer diagnostic 
    #[Route('/{id}', name: 'app_diagnostic_request_delete', methods: ['POST'])]
    public function delete(Request $request, DiagnosticRequest $diagnosticRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diagnosticRequest->getId(), $request->request->get('_token'))) {
            $entityManager->remove($diagnosticRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_diagnostic_request_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/index_sorted_by_creation_date', name: 'app_diagnostic_request_index_sorted_by_creation_date', methods: ['GET'])]
  
    public function indexSortedByCreationDate(DiagnosticRequestRepository $diagnosticRequestRepository): Response
    {
        $diagnosticRequests = $diagnosticRequestRepository->findAllSortedByCreationDate();
    
        return $this->render('diagnostic_request/index2.html.twig', [
            'diagnostic_requests' => $diagnosticRequests,
        ]);
    }
}
