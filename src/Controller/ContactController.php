<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\MarqueType;
use App\Services\MailerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="Contact_nous")
     */
    public function indexNew(Request $request,MailerService $mailerService): Response
    {
        $form = $this->createForm(ContactType::class, null);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            //dd($data);
            $mailerService->send(
                $data['message'],
                $data['email'],
                "konatenhamed@gmail.com",
                "contact/template.html.twig",
                [
                   'message'=>  $data['message'],
                   'email'=>  $data['email'],
                   'nom' =>  $data['nom'],
                   'prenom' =>  $data['prenom'],
                   'telephone' =>  $data['telephone']
                ]
            );
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
