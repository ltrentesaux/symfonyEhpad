<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;

use App\Repository\PersonneRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', 'contact.index')]
    public function index(
        ContactRepository $contactRepository,
        PersonneRepository $personneRepository,
        Request $request
    ): Response {
        $contact = new Contact();
        $form=$this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $message=null;

        if($form->isSubmitted() && $form->isValid()) {
            $admin=$personneRepository->find('admin');
            $contact->setLogin($admin);
            $contactRepository->save($contact, true);
            $message= 'Contact correctement enregistré';

        }

        return $this->render('contact/index.html.twig', [
            'formulaire' => $form->createView(),
            'message' => $message
        ]);
    }
}
