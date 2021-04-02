<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransmissionController extends AbstractController
{
    /**
     * @Route("/transmission", name="Transmission")
     */
    public function index(): Response
    {
        $em =$this->getDoctrine()->getManager();

        $commune = $em->getRepository(Produit::class)->findOneBy(['id'=>1]);
//dd($commune);
        return $this->render('transmission/index.html.twig', [
          'commune'=>$commune
        ]);
    }
}
