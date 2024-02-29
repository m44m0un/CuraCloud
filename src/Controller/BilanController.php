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

#[Route('/bilan')]
class BilanController extends AbstractController
{
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
        return $this->render('bilan/index2.html.twig', [
            'bilans' => $bilanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bilan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bilan = new Bilan();
        $form = $this->createForm(BilanType::class, $bilan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bilan);
            $entityManager->flush();

            return $this->redirectToRoute('app_bilan_index', [], Response::HTTP_SEE_OTHER);
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

            return $this->redirectToRoute('app_bilan_index', [], Response::HTTP_SEE_OTHER);
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
}
