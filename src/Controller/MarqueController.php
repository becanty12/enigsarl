<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/marque")
 */
class MarqueController extends AbstractController
{
    /**
     * en effet il sagit des partenaire TODO
     * @Route("/marque", name="marque")
     */
    public function index(): Response
    {
        $listePartenaire = $this->getDoctrine()->getRepository(Marque::class)->findAll();
        return $this->render('marque/index.html.twig', [
            'titre' => 'Liste des partenaires',
            'listePartenaires' => $listePartenaire
        ]);
    }

    /**
     * @Route("/new", name="partenaire_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface  $slugger)
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        // dd($form->get('image')->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('logo')->getData(); //get('image_prod')->getData();
            $newFilename = md5(uniqid()) . '.' . $brochureFile->guessExtension();
            $brochureFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $marque->setLogo($newFilename);
            //$post->setTitle("premier test");
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush();


            return $this->redirectToRoute('admin_dashboard');
        }


        return $this->render('marque/new.html.twig', [
            'marques' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editer/{id}", name="partenaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $marque = $entityManager->getRepository(Marque::class)->find($id);
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('logo')->getData();
            $newFilename = md5(uniqid()) . '.' . $brochureFile->guessExtension();
            $brochureFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $marque->setLogo($newFilename);
            //$post->setTitle("premier test");
            $em = $this->getDoctrine()->getManager();
            $em->persist($marque);
            $em->flush();


            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render("marque/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
