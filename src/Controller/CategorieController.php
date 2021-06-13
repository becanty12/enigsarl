<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        $listecategorie=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            'titre' => 'Liste des catégories',
            'listecategories'=>$listecategorie
        ]);
    }

    /**
     * @Route("/new", name="categorie_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface  $slugger)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

      // dd($form->get('image')->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('image')->getData();//get('image_prod')->getData();
            $newFilename = md5(uniqid()).'.'.$brochureFile->guessExtension();
            $brochureFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $categorie->setImage($newFilename);
            //$post->setTitle("premier test");
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();


            return $this->redirectToRoute('admin_dashboard');
        }


        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editer/{id}", name="categorie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,$id){
        $entityManager = $this->getDoctrine()->getManager();

        $categorie = $entityManager->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('image')->getData();//get('image_prod')->getData();
            $newFilename = md5(uniqid()).'.'.$brochureFile->guessExtension();
            $brochureFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );

            $categorie->setImage($newFilename);
            //$post->setTitle("premier test");
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();


            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render("categorie/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
