<?php

namespace App\Controller;

use App\Entity\Software;
use App\Form\SoftwareType;
use App\Repository\SoftwareRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/admin/software")
 */
class SoftwareController extends AbstractController
{
    /**
     * @Route("/", name="software_index", methods={"GET"})
     */
    public function index(SoftwareRepository $softwareRepository): Response
    {
        return $this->render('software/index.html.twig', [
            'software' => $softwareRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="software_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $software = new Software();
        $form = $this->createForm(SoftwareType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $fileTmp */
            $fileTmp = $form->get('image')->getData();

            $fileName = md5(uniqid()) . '.' . $fileTmp->guessExtension();

            // moves the file to the directory where avatar are stored
            $fileTmp->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            $software->setImage($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($software);
            $entityManager->flush();

            return $this->redirectToRoute('software_index');
        }

        return $this->render('software/new.html.twig', [
            'software' => $software,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="software_show", methods={"GET"})
     */
    public function show(Software $software): Response
    {
        return $this->render('software/show.html.twig', [
            'software' => $software,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="software_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Software $software): Response
    {
        $originFile = $software->getImage();
        $form = $this->createForm(SoftwareType::class, $software);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $fileTmp */
            $fileTmp = $form['image']->getData();
            if (isset($fileTmp)) {
                $fileName = md5(uniqid()) . '.' . $fileTmp->guessExtension();

                // moves the file to the directory where avatar are stored
                $fileTmp->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );

                $software->setImage($fileName);

                $filesystem = new Filesystem();
                $fileDelete = $this->getParameter('images_directory') . '/' . $originFile;
                if ($filesystem->exists($fileDelete)) {
                    $filesystem->remove($fileDelete);
                }
            } else {
                $software->setImage($originFile);
            }

            $this->getDoctrine()->getManager()->persist($software);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('software_index');
        }

        return $this->render('software/edit.html.twig', [
            'software' => $software,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="software_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Software $software): Response
    {
        if ($this->isCsrfTokenValid('delete'.$software->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($software);
            $entityManager->flush();
        }

        return $this->redirectToRoute('software_index');
    }
}
