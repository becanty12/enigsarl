<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin_dashboard", name="admin_dashboard")
     */
    public function index(): Response
    {
        $modules = [
            [
                'label' => 'Categories',
                'titre'=> 'Liste des categories',
                'icon' => 'far fa-list-alt',
                'href' => $this->generateUrl('categorie')

            ],
            [
                'label' => 'Produit',
                'titre'=> 'Liste des produits',
                'icon' => 'far fa-list-alt',
                'href' => $this->generateUrl('produit')

            ],
            [
                'label' => 'Marque',
                'titre'=> 'Liste des marques',
                'icon' => 'far fa-list-alt',
                'href' => $this->generateUrl('marque')

            ],
        ];
        //dd($modules);
        return $this->render('admin/index.html.twig', [
            'modules' => $modules,
        ]);
    }
}
