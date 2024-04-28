<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AbsenceController extends AbstractController
{
    #[Route('/notificar', name: 'notify_main')]
    public function index(): Response
    {
        return $this->render('Notify/main.html.twig', []);
    }
}