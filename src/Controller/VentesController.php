<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VentesController extends AbstractController
{
    #[Route('/ventes/liste', name: 'app_ventes_liste')]
    public function index(): Response
    {
        return $this->render('ventes/liste.html.twig', [
            'controller_name' => 'VentesController',
        ]);
    }
}
