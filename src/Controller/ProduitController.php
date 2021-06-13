<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\CategorieType;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;


/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        $listeproduit=$produitRepository->affiche_produit_all();//$this->getDoctrine()->getRepository(Produit::class)->findAll();
//dd($listeproduit);
        return $this->render('produit/index.html.twig', [
            'titre' => 'Liste des produits',
            'listeproduit' => $listeproduit,
        ]);
    }

    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface  $slugger)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        //dd($form->get('image')->getData().[0]);




        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('image')->getData();//get('image_prod')->getData();

            foreach ($brochureFile as $image) {
                $file=new File($image->getPath());
                $newFilename = md5(uniqid()).'.'. $file->guessExtension();
               // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('images_directory'), $newFilename);
                $image->setPath($newFilename);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();


            return $this->redirectToRoute('admin_dashboard');
        }


        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editer/{id}", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,$id){
        $entityManager = $this->getDoctrine()->getManager();

        $produit = $entityManager->getRepository(Produit::class)->find($id);
        $form = $this->createForm(CategorieType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('image')->getData();//get('image_prod')->getData();

            foreach ($brochureFile as $image) {
                $file=new File($image->getPath());
                $newFilename = md5(uniqid()).'.'. $file->guessExtension();
                // $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('images_directory'), $newFilename);
                $image->setPath($newFilename);
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();


            return $this->redirectToRoute('admin_dashboard');
        }


        return $this->render("produit/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
