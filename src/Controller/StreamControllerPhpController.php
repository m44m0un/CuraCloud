<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StreamControllerPhpController extends AbstractController
{
    #[Route('/stream/controller/php', name: 'app_stream_controller_php')]
    public function index(): Response
    {
        return $this->render('stream_controller_php/index.html.twig', [
            'controller_name' => 'StreamControllerPhpController',
        ]);
    }
}
