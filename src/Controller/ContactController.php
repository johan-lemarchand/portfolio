<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact",methods={"GET","POST"})
     */
    public function contact( Request $request, \Swift_Mailer $mailer): Response
    {
        $contact = new Contact();
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $firstname = $form->get('nom')->getData();
            $lastname = $form->get('prenom')->getData();
            $email = $form->get('email')->getData();
            $content = $form->get('message')->getData();

            $message = (new \Swift_Message())
               ->setSubject('contact portfolio')
               ->setFrom(['johan27000@gmail.com' => $email])
               ->setTo('johan27000@gmail.com')
               ->setBody("<h1>$content,<br/> Envoyé par : $firstname , $lastname </h1>", 'text/html');
               $result = $mailer->send($message);

               
               $this->addFlash('success', 'Votre message est bien envoyé !');
               return $this->redirectToRoute('home');

        }
        return $this->render('contact/contact.html.twig', [
        
            'controller_name' => 'ContactController',
            'formContact' => $form->createView()
            
        ]);
    }
    }
        
        


            


