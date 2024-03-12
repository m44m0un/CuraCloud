<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Likes;
use App\Entity\DisLike;
use App\Entity\Comments;
use App\Form\BlogType;
use App\Form\CommentsType;
use App\Repository\BlogRepository;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\CustomBlogSearchType;

#[Route('/blog')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog_index', methods: ['GET'])]
    public function index(BlogRepository $blogRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $page = $request->query->getInt('page', 1);
        $perPage = 6; // Adjust the number of blogs per page as needed
    
        // Create an instance of the search form
        $searchForm = $this->createForm(CustomBlogSearchType::class); // Update this line with your actual form type
    
        // Handle the form submission if applicable
        $searchForm->handleRequest($request);
    
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            // Handle form submission and update the query accordingly
            $searchTerm = $searchForm->get('search')->getData();
            $query = $blogRepository->createQueryBuilder('b')
                ->andWhere('b.title LIKE :term OR b.subject LIKE :term OR b.author.firstName LIKE :term OR b.author.lastName LIKE :term')
                ->setParameter('term', "%$searchTerm%")
                ->getQuery();
    
            $pagination = $paginator->paginate(
                $query,
                $page,
                $perPage
            );
        } else {
            // Use the original query for non-search requests
            $query = $blogRepository->createQueryBuilder('b')
                ->getQuery();
    
            $pagination = $paginator->paginate(
                $query,
                $page,
                $perPage
            );
        }
    
        $totalBlogs = $blogRepository->count([]); // Count total blogs
        $totalPages = ceil($totalBlogs / $perPage);
    
        if ($request->isXmlHttpRequest()) {
            // If it's an AJAX request, render only the search results
            return $this->render('_search_results.html.twig', [
                'blogs' => $pagination,
                'page' => $page,
                'totalPages' => $totalPages,
            ]);
        }
    
        // For regular requests, render the entire page with the search form and results
        return $this->render('blog/index.html.twig', [
            'blogs' => $pagination,
            'page' => $page,
            'totalPages' => $totalPages,
            'searchForm' => $searchForm->createView(), // Pass the search form to the template
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
            // Set the author of the blog to the authenticated user
            $user = $this->getUser();
            $blog->setAuthor($user);
    
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

    



    /////LIKE CONTROLLER/////


    #[Route('/blog/{id}/like', name: 'app_blog_like', methods: ['POST'])]
    public function like(Blog $blog, EntityManagerInterface $entityManager): Response
    {
        // Ensure user is logged in (you might want to handle this according to your authentication system)
        $user = $this->getUser();
        if (!$user) {
            // Handle case when user is not authenticated
            return $this->redirectToRoute('app_blog_show', ['id' => $blog->getId()]);
        }
    
        // Check if the user has already liked the blog
        $existingLike = $entityManager->getRepository(Likes::class)->findOneBy([
            'user' => $user,
            'blog' => $blog,
        ]);
    
        // Check if the user has disliked the blog
        $existingDislike = $entityManager->getRepository(Dislike::class)->findOneBy([
            'user' => $user,
            'blog' => $blog,
        ]);
    
        // If the user has already liked the blog, remove the like
        if ($existingLike) {
            // Remove the existing like
            $entityManager->remove($existingLike);
            $entityManager->flush();
    
            // Add a flash message
            $this->addFlash('success', 'You have removed your like for the blog.');
        } elseif ($existingDislike) {
            // Remove the existing dislike
            $entityManager->remove($existingDislike);
    
            // Create a new Like entity
            $like = new Likes();
            $like->setUser($user);
            $like->setBlog($blog);
    
            // Persist and flush the changes
            $entityManager->persist($like);
            $entityManager->flush();
    
            // Add a flash message
            $this->addFlash('success', 'You have liked the blog.');
        } else {
            // Create a new Like entity
            $like = new Likes();
            $like->setUser($user);
            $like->setBlog($blog);
    
            // Persist and flush the changes
            $entityManager->persist($like);
            $entityManager->flush();
    
            // Add a flash message
            $this->addFlash('success', 'You have liked the blog.');
        }
    
        // Redirect to the blog page or any other desired page
        return $this->redirectToRoute('app_blog_show', ['id' => $blog->getId()]);
    }
    
    


    //////DISLIKES SECTION ///////

    #[Route('/blog/{id}/dislike', name: 'app_blog_dislike', methods: ['POST'])]
    public function dislike(Blog $blog, EntityManagerInterface $entityManager): Response
    {
        // Ensure user is logged in (you might want to handle this according to your authentication system)
        $user = $this->getUser();
        if (!$user) {
            // Handle case when user is not authenticated
            return $this->redirectToRoute('app_login');
        }
    
        // Check if the user has already disliked the blog
        $existingDislike = $entityManager->getRepository(Dislike::class)->findOneBy([
            'user' => $user,
            'blog' => $blog,
        ]);
    
        // Check if the user has liked the blog
        $existingLike = $entityManager->getRepository(Likes::class)->findOneBy([
            'user' => $user,
            'blog' => $blog,
        ]);
    
        if ($existingDislike) {
            // If the user already disliked the blog, delete the dislike
            $entityManager->remove($existingDislike);
            $entityManager->flush();
            $this->addFlash('success', 'You have removed your dislike.');
        } elseif ($existingLike) {
            // If the user liked the blog, delete the like and add a dislike
            $entityManager->remove($existingLike);
    
            $dislike = new Dislike();
            $dislike->setUser($user);
            $dislike->setBlog($blog);
            $entityManager->persist($dislike);
            $entityManager->flush();
    
            $this->addFlash('success', 'You have changed your like to a dislike.');
        } else {
            // If the user hasn't disliked the blog, add a new dislike
            $dislike = new Dislike();
            $dislike->setUser($user);
            $dislike->setBlog($blog);
            $entityManager->persist($dislike);
            $entityManager->flush();
    
            $this->addFlash('success', 'You have disliked the blog.');
        }
    
        // Redirect to the blog page or any other desired page
        return $this->redirectToRoute('app_blog_show', ['id' => $blog->getId()]);
    }
    


    
}