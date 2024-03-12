<?php

namespace App\Controller;

use App\Repository\DiagnosticRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TriDiagnosticController extends AbstractController
{
   
    #[Route('index_sorted_by_name', name:'app_diagnostic_request_sorted_by_name')]
     
    public function showDiagnosticRequests(DiagnosticRequestRepository $diagnosticRequestRepository): Response
    {
        $diagnosticRequests = $diagnosticRequestRepository->findAllOrderedByUserName();

        return $this->render('diagnostic_request/index2.html.twig', [
            'diagnostic_requests' => $diagnosticRequests,
        ]);
    }

    #[Route('/stat', name: 'app_dashboard')]
        public function Trier (DiagnosticRequestRepository $rep): Response
        {
    
            $livreurs = $rep->countByRegion();
            $regionL = [];
            $countL = [];
            foreach ($livreurs as $liv) {
                $regionL[] = $liv['regionL'];
                $countL[] = $liv['countL'];
           }
    
            return $this->render('diagnostic_request/stat.html.twig', [
                'controller_name' => 'NomController',
                'regionL' => json_encode($regionL),
                'countL' => json_encode($countL),
            ]);
        }
        #[Route('/search', name: 'app_diagnostic_request_search', methods: ['GET'])]
        public function search(DiagnosticRequestRepository $diagnosticRequestRepository, Request $request): Response
        {
            // Récupérez les critères de recherche depuis la requête
            $criteria = [
                'analyseType' => $request->query->get('analyseType'), // Exemple avec le type d'analyse
                // Ajoutez d'autres critères si nécessaire
            ];
    
            // Utilisez la méthode de recherche du repository
            $diagnosticRequests = $diagnosticRequestRepository->search($criteria);
    
            return $this->render('diagnostic_request/search_results.html.twig', [
                'diagnostic_requests' => $diagnosticRequests,
            ]);
        }
    
        // ...
}
