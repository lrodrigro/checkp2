<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Software;
use App\Repository\CategoryRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontCategoryController extends AbstractController
{
    /**
     * @Route("/category", name="front_category")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('front_category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="front_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        $software = new Software();
        $software = $category->getSoftware();
        return $this->render('front_category/show.html.twig', [
            'category' => $category,
            'softwares' => $software,
        ]);
    }
}
