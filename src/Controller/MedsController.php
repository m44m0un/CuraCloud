<?php

namespace App\Controller;

use App\Entity\Meds;
use App\Form\MedsType;
use App\Repository\MedsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/meds')]
class MedsController extends AbstractController
{
    #[Route('/', name: 'app_meds_index', methods: ['GET'])]
    public function index(MedsRepository $medsRepository): Response
    {
        return $this->render('meds/index.html.twig', [
            'meds' => $medsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_meds_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $med = new Meds();
        $form = $this->createForm(MedsType::class, $med);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($med);
            $entityManager->flush();

            return $this->redirectToRoute('app_meds_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('meds/new.html.twig', [
            'med' => $med,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meds_show', methods: ['GET'])]
    public function show(Meds $med): Response
    {
        return $this->render('meds/show.html.twig', [
            'med' => $med,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_meds_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meds $med, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MedsType::class, $med);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_meds_index'); // Corrected redirect route
        }

        return $this->render('meds/edit.html.twig', [
            'med' => $med,
            'form' => $form->createView(), // Ensure form is passed as a view
        ]);
    }

    #[Route('/{id}', name: 'app_meds_delete', methods: ['POST'])]
    public function delete(Request $request, Meds $med, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$med->getId(), $request->request->get('_token'))) {
            $entityManager->remove($med);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_meds_index', [], Response::HTTP_SEE_OTHER);
    }
}
