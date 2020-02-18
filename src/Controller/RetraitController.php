<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RetraitController extends AbstractController
{
    /**
     * @Route("/retrait", name="retrait")
     */
    public function index()
    {
        return $this->render('retrait/index.html.twig', [
            'controller_name' => 'RetraitController',
        ]);
    }
}
