<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Blog;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comments')]
class CommentsController extends AbstractController
{
    #[Route('/', name: 'app_comments_index', methods: ['GET'])]
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('comments/index.html.twig', [
            'comments' => $commentsRepository->findAll(),
        ]);
    }

    // #[Route('/new', name: 'app_comments_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $comment = new Comments();
    //     $form = $this->createForm(CommentsType::class, $comment);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($comment);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('comments/new.html.twig', [
    //         'comment' => $comment,
    //         'form' => $form,
    //     ]);
    // }
    #[Route('/new/{blogId}', name: 'app_comments_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, $blogId): Response
{
    // Retrieve the blog using $blogId
    $blog = $this->getDoctrine()->getRepository(Blog::class)->find($blogId);

    // Create a new comment
    $comment = new Comments();
    $comment->setBlogId($blog); // Set the association with the correct blog

    // Handle the form submission
    $form = $this->createForm(CommentsType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($comment);
        $entityManager->flush();

        // Redirect back to the blog show page after adding a comment
        return $this->redirectToRoute('app_blog_show', ['id' => $blog->getId()]);
    }

    // Fetch existing comments for rendering
    $existingComments = $this->getDoctrine()->getRepository(Comments::class)->findBy(['blogId' => $blogId]);

    return $this->render('blog/show.html.twig', [
        'blog' => $blog,
        'comments' => $existingComments,
        'form' => $form->createView(),
    ]);
}


    #[Route('/{id}', name: 'app_comments_show', methods: ['GET'])]
    public function show(Comments $comment): Response
    {
        return $this->render('comments/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comments $comment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comments_delete', methods: ['POST'])]
    public function delete(Request $request, Comments $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
    }
}
