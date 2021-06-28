<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\MarqueType;
use App\Services\MailerService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="Contact_nous")
     */
    public function indexNew(Request $request, MailerService $mailerService,EntityManagerInterface $em): Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $mailerService->send(
                $data->getMessage(),
                $data->getEmail(),
                "konatenhamed@gmail.com",
                "contact/template.html.twig",
                [
                    'message' =>  $data->getMessage(),
                    'email' =>  $data->getEmail(),
                    'nom' =>  $data->getNom(),
                    'prenom' =>  $data->getPrenom(),
                    'telephone' =>  $data->getTelephone()
                ]
            );
            $em->persist($contact);
            $em->flush();
            return $this->redirectToRoute('Contact_nous');


        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
