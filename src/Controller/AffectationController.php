<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AffectationController extends AbstractController
{
    /**
     * @Route("/affectation", name="affectation")
     */
    public function index()
    {
        return $this->render('affectation/index.html.twig', [
            'controller_name' => 'AffectationController',
        ]);
    }
}
