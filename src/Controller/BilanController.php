<?php

namespace App\Controller;

use App\Entity\Bilan;
use App\Form\BilanType;
use App\Repository\BilanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use MercurySeries\FlashyBundle\FlashyNotifier;



#[Route('/bilan')]
class BilanController extends AbstractController
{   
     private $flashyNotifier;
     public function __construct(FlashyNotifier $flashyNotifier)
    {
        $this->flashyNotifier = $flashyNotifier;
    }

    #[Route('/', name: 'app_bilan_index', methods: ['GET'])]
    public function index(BilanRepository $bilanRepository): Response
    {
        return $this->render('bilan/index.html.twig', [
            'bilans' => $bilanRepository->findAll(),
        ]);
    }

    //Index2 : pour le médecin 
    #[Route('/index2', name: 'app_bilan_index2', methods: ['GET'])]
    public function index2(BilanRepository $bilanRepository): Response
    {
        $successFlash = $this->get('session')->getFlashBag()->get('success');
        
        return $this->render('bilan/index2.html.twig', [
            'bilans' => $bilanRepository->findAll(),
            'successFlash' => $successFlash,
        ]);
    }



    #[Route('/new', name: 'app_bilan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bilan = new Bilan();
        $form = $this->createForm(BilanType::class, $bilan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // if ($form->get('imageFile')->getData() instanceof UploadedFile) {
                // Gérer l'upload de l'image avec VichUploaderBundle
             //   $bilan->setImageFile($form->get('imageFile')->getData());
            //}
            //Traitement de l'image téléchargée
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile instanceof UploadedFile) {
                // Gérer l'upload de l'image avec VichUploaderBundle
                $bilan->setImageFile($imageFile);
            }
                
            $entityManager->persist($bilan);
            $entityManager->flush();
            $this->flashyNotifier->success('Activity created with success !');

            return $this->redirectToRoute('app_bilan_index2', [], Response::HTTP_SEE_OTHER);
            
        }

        return $this->renderForm('bilan/new.html.twig', [
            'bilan' => $bilan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bilan_show', methods: ['GET'])]
    public function show(Bilan $bilan): Response
    {
        return $this->render('bilan/show.html.twig', [
            'bilan' => $bilan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bilan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bilan $bilan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BilanType::class, $bilan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->flashyNotifier->success('Activity Updated with success !');

            return $this->redirectToRoute('app_bilan_index2', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bilan/edit.html.twig', [
            'bilan' => $bilan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bilan_delete', methods: ['POST'])]
    public function delete(Request $request, Bilan $bilan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bilan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bilan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bilan_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/generate-pdf', name: 'app_bilan_generate_pdf', methods: ['GET'])]
public function generatePdf(Bilan $bilan): Response
{
    // Créer une instance de Dompdf
    $dompdf = new Dompdf();

    // Options pour Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf->setOptions($options);

    // Générer le HTML du PDF (vous devez créer un fichier Twig pour le contenu du PDF)
    $html = $this->renderView('bilan/pdf_template.html.twig', ['bilan' => $bilan]);

    // Charger le HTML dans Dompdf
    $dompdf->loadHtml($html);

    // Rendre le PDF
    $dompdf->render();

    // Générer un nom de fichier pour le PDF
    $filename = 'bilan_' . $bilan->getId() . '.pdf';

    // Envoyer le PDF au navigateur
    $dompdf->stream($filename, [
        'Attachment' => true,
    ]);

    return new Response();
}





    
}
