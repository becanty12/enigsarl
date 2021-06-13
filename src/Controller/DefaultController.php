<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Marque;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/equipe", name="notre_equipe")
     */
    public function indexPartenaire()
    {
        return $this->render('default/partenaire.html.twig', []);
    }


    /**
     * @Route("/about", name="a_propos_de_nous")
     */
    public function indexAbout()
    {

        $listePartenaire = $this->getDoctrine()->getRepository(Marque::class)->findAll();
        return $this->render('default/about.html.twig', [
            'listePartenaires' => $listePartenaire,
        ]);
    }


    /**
     * @Route("/acceuil", name="default")
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->listeCategorie();
        $listeCategorie = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        return $this->render('default/index.html.twig', [
            'listeCategorie' => $listeCategorie
        ]);
    }

    /**
     * @Route("/affiche_produits/{id}", name="affiche_produits")
     */
    public function afficheProduit($id, CategorieRepository $categorieRepository)
    {

        $listeCategorie = $categorieRepository->affiche_produit($id);
        $libelle = array();
        foreach ($listeCategorie as $p) {
            if (!in_array($p['libelle'], $libelle)) {
                $libelle[] = $p['libelle'];
            }
        }
        //dd($libelle);
        return $this->render('default/affiche_produit.html.twig', [
            'libelles' => $libelle,
            'listeCategorie' => $listeCategorie
        ]);
    }

    /**
     * @Route("/affiche_un_produit/{id}", name="affiche_un_produit")
     */
    public function afficheProduitOne($id, CategorieRepository $categorieRepository)
    {

        $listeproduits = $categorieRepository->affiche_produit_one($id);
        /*dd($listeproduits);*/
        return $this->render('default/affiche_produit_one.html.twig', [
            'titre' => ($listeproduits == []) ? " " : $listeproduits[0]['libelle'],
            'listeproduits' => $listeproduits
        ]);
    }

    /**
     * Undocumented function
     *@Route("/test",name="test")
     * @return void
     */
    public function test()
    {

        return $this->render('test.html.twig');
    }
}
