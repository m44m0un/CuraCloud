<?php

// src/Controller/StreamController.php

namespace App\Controller;

use App\Repository\StreamRepository;
use App\Entity\Stream;
use App\Entity\User;
use App\Form\StreamType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MessageStream;
use App\Form\MessageStreamType;

class StreamController extends AbstractController
{
    #[Route("/stream", name: "stream_index")]
    public function index(StreamRepository $streamRepository): Response
    {
        // Fetch all active streams
        $activeStreams = $streamRepository->findAllActiveStreams();

        return $this->render('stream/view_streams.html.twig', [
            'activeStreams' => $activeStreams,
        ]);
    }

    #[Route("/stream/create", name: "stream_create")]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the authenticated user
        $user = $this->getUser();

        // Create a new Stream instance with the authenticated user
        $stream = new Stream($user, '');

        // Create the form
        $form = $this->createForm(StreamType::class, $stream);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the entity
            $entityManager->persist($stream);
            $entityManager->flush();

            // Redirect to the user's stream page
            return $this->redirectToRoute('user_stream', ['id' => $this->getUser()->getId()]);
        }

        return $this->render('stream/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/user/{id}/end-stream", name: "end_stream")]
    public function endStream(User $user, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
    {
        $streamRepository = $entityManager->getRepository(Stream::class);
    
        // Fetch the user's active stream
        $activeStream = $streamRepository->findActiveStreamByUser($user->getId());
    
        if ($activeStream) {
            // Remove the stream entity
            $entityManager->remove($activeStream);
            $entityManager->flush(); // Synchronize changes with the database
        }
    
        // Redirect back to the streams page
        return $this->redirectToRoute('view_streams');
    }

    #[Route("/user/{id}/stream", name: "user_stream")]
    public function userStream(User $user, StreamRepository $streamRepository): Response
    {
        // Fetch the user's active or inactive stream
        $stream = $streamRepository->findActiveStreamByUser($user->getId());

        return $this->render('stream/user_stream.html.twig', [
            'user' => $user,
            'stream' => $stream,
        ]);
    }

    #[Route("/stream/{streamId}", name: "view_stream")]
    public function viewStream(int $streamId, StreamRepository $streamRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Fetch the stream by ID
        $stream = $streamRepository->find($streamId);
    
        if (!$stream || !$stream->getIsActive()) {
            // Redirect to the stream index page or show an error page
            return $this->redirectToRoute('stream_index');
        }
    
        // Create a new message stream instance
        $messageStream = new MessageStream();
        $messageStream->setStream($stream);
        $messageStream->setUser($this->getUser()); // Set the user here
    
        // Create the message form
        $messageForm = $this->createForm(MessageStreamType::class, $messageStream);
    
        $messageForm->handleRequest($request);
    
        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            // Persist the message entity
            $entityManager->persist($messageStream);
            $entityManager->flush();
    
            // Redirect to the same stream view page after submitting the message
            return $this->redirectToRoute('view_stream', ['streamId' => $streamId]);
        }
    
        return $this->render('stream/view_stream.html.twig', [
            'stream' => $stream,
            'messageForm' => $messageForm->createView(),
        ]);
    }

#[Route("/streams", name: "view_streams")]
public function viewStreams(StreamRepository $streamRepository): Response
{
    // Fetch all active streams
    $activeStreams = $streamRepository->findAllActiveStreams();

    return $this->render('stream/view_streams.html.twig', [
        'activeStreams' => $activeStreams,
    ]);
}



}
