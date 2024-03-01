<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comments;
use App\Form\BlogType;
use App\Form\CommentsType;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/blog')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog_index', methods: ['GET'])]
public function index(BlogRepository $blogRepository, Request $request, PaginatorInterface $paginator): Response
{
    $page = $request->query->getInt('page', 1);
    $perPage = 6; // Adjust the number of blogs per page as needed

    $query = $blogRepository->createQueryBuilder('b')
        ->getQuery();

    $pagination = $paginator->paginate(
        $query,
        $page,
        $perPage
    );

    $totalBlogs = $blogRepository->count([]); // Count total blogs
    $totalPages = ceil($totalBlogs / $perPage);

    return $this->render('blog/index.html.twig', [
        'blogs' => $pagination,
        'page' => $page,
        'totalPages' => $totalPages,
    ]);
}
    #[Route('/back', name: 'back_app_blog_index', methods: ['GET'])]
    public function Backindex(BlogRepository $blogRepository): Response
    {
        $blogs = $blogRepository->findAll();

        return $this->render('blog/back.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    #[Route('/new', name: 'app_blog_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('blog_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something goes wrong during file upload
                    // You might want to add some logging here
                }

                $blog->setImage($newFilename);
            }

            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_show', methods: ['GET'])]
public function show(Blog $blog, Request $request, EntityManagerInterface $entityManager): Response
{
    $comment = new Comments();
    $commentForm = $this->createForm(CommentsType::class, $comment);
    $commentForm->handleRequest($request);

    if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        $entityManager->persist($comment);
        $entityManager->flush();

        // Redirect to the blog show page after submitting the comment
        return $this->redirectToRoute('app_blog_show', ['id' => $blog->getId()], Response::HTTP_SEE_OTHER);
    }

    return $this->render('blog/show.html.twig', [
        'blog' => $blog,
        'form' => $commentForm->createView(),
    ]);
}

    #[Route('/back/{id}', name: 'back_app_blog_show', methods: ['GET'])]
    public function backshow(Blog $blog): Response
    {
        $comment = new Comments();
        $commentForm = $this->createForm(CommentsType::class, $comment);

        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
            'form' => $commentForm->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blog $blog, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('blog_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something goes wrong during file upload
                    // You might want to add some logging here
                }

                $blog->setImage($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_delete', methods: ['POST'])]
    public function delete(Request $request, Blog $blog, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
    }
}