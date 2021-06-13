<?php

namespace App\Controller;

use App\Entity\Post;
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
      $rest=$em->getRepository(Post::class)->findBy(['title'=>'konate']);
//dd($rest);
        return $this->render('transmission/index.html.twig', [
          'commune'=>$rest
        ]);
        }      
}
