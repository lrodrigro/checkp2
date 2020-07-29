<?php

namespace App\Controller;

use App\Entity\Software;
use App\Repository\SoftwareRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontSoftwareController extends AbstractController
{
    /**
     * @Route("/software", name="front_software")
     */
    public function index(SoftwareRepository $softwareRepository): Response
    {
        return $this->render('front_software/index.html.twig', [
            'softwares' => $softwareRepository->findAll(),
        ]);
    }
}
