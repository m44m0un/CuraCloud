<?php

namespace App\Controller;

use App\Entity\DiagnosticRequest;
use App\Entity\User;
use App\Form\DiagnosticRequestType;
use App\Repository\DiagnosticRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Security as CoreSecurity; // Ajoutez cette ligne



#[Route('/diagnostic/request')]
class DiagnosticRequestController extends AbstractController
{

    private CoreSecurity $security; // Modifiez le type et le nom de la propriété

    public function __construct(CoreSecurity $security) // Modifiez le type du paramètre
    {
        $this->security = $security;
    }
    
    #[Route('/', name: 'app_diagnostic_request_index', methods: ['GET'])]
    public function index(DiagnosticRequestRepository $diagnosticRequestRepository): Response
    {
        $currentUser = $this->security->getUser();

        // Vérifier si l'utilisateur est connecté
        if ($currentUser instanceof User) {
            // Récupérer les analyses attribuées à l'utilisateur connecté
            $diagnosticRequests = $diagnosticRequestRepository->getUserConnected($currentUser->getId());

            return $this->render('diagnostic_request/index.html.twig', [
                'diagnostic_requests' => $diagnosticRequests,
            ]);
        }
    }

    #[Route('/index2', name: 'app_diagnostic_request_index2', methods: ['GET'])]
    public function index2(DiagnosticRequestRepository $diagnosticRequestRepository): Response
    {
        return $this->render('diagnostic_request/index2.html.twig', [
            'diagnostic_requests' => $diagnosticRequestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_diagnostic_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $diagnosticRequest = new DiagnosticRequest();
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

    #[Route('/{id}', name: 'app_diagnostic_request_show', methods: ['GET'])]
    #[ParamConverter('diagnosticRequest', class: DiagnosticRequest::class)]
    public function show(DiagnosticRequest $diagnosticRequest): Response
    {
        return $this->render('diagnostic_request/show.html.twig', [
            'diagnostic_request' => $diagnosticRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_diagnostic_request_edit', methods: ['GET', 'POST'])]
    #[ParamConverter('diagnosticRequest', class: DiagnosticRequest::class)]
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

    
    

    #[Route('/diagnostic-request/{id}/results', name: 'diagnostic_results')]
    #[ParamConverter('diagnosticRequest', class: DiagnosticRequest::class)]
    public function showDiagnosticResults(DiagnosticRequest $diagnosticRequest): Response
    {
        // Fetch the associated bilans
        $bilans = $diagnosticRequest->getDiagnosticBilans();

        return $this->render('bilan/index2.html.twig', [
            'diagnosticRequest' => $diagnosticRequest,
            'bilans' => $bilans,
        ]);
    }

    #[Route('/statistics', name: 'app_statistics')]
    public function statistics(DiagnosticRequestRepository $reclamationRepository): Response
    {
        $statut = $reclamationRepository->getDistinctCategories();
        $totalReclamations = $reclamationRepository->countAll(); // Nouvelle méthode pour obtenir le total des réclamations

        $data = [];

        foreach ($statut as $statut) {
            $count = $reclamationRepository->countByCategory($statut);
            $percentage = ($totalReclamations > 0) ? ($count / $totalReclamations) * 100 : 0;
            $data[] = ['category' => $statut, 'percentage' => $percentage];
        }

        return $this->render('diagnostic_request/stat.html.twig', [
            'data' => json_encode($data),
        ]);
    }

   




}
