<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontSoftwareController extends AbstractController
{
    /**
     * @Route("/software", name="front_software")
     */
    public function index()
    {
        return $this->render('front_software/index.html.twig', [
            'controller_name' => 'FrontSoftwareController',
        ]);
    }
}
