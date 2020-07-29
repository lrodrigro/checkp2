<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front_index")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('front/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}
