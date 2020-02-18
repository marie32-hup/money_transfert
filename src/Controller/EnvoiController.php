<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EnvoiController extends AbstractController
{
    /**
     * @Route("/envoi", name="envoi")
     */
    public function index()
    {
        return $this->render('envoi/index.html.twig', [
            'controller_name' => 'EnvoiController',
        ]);
    }
}
