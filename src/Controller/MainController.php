<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Form\ContactType;
use App\Message\SendMailMessage;
use App\Service\SendMailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
  #[Route('/', name: 'main')]
  public function index(): Response
  {
    return $this->render('main/main.html.twig');
  }

  #[Route('/contact', name: 'contact')]
  public function contact(Request $request, SendMailService $mail, MessageBusInterface $messageBus): Response
  {
    $form = $this->createForm(ContactType::class);

    $contact = $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $context = [
        'name' => $contact->get('name')->getData(),
        'firstname' => $contact->get('firstname')->getData(),
        'mail' => $contact->get('email')->getData(),
        'phone' => $contact->get('phone')->getData(),
        'subject' => $contact->get('subject')->getData(),
        'message' => $contact->get('message')->getData(),
      ];
      
      $messageBus->dispatch(
        new SendMailMessage(
          $contact->get('email')->getData(),
          'contact@barhome.com',
          'Bar Home - Contact',
          'contact',
          $context
        )
      );

      // $mail->send(
      //     $contact->get('email')->getData(),
      //     'contact@barhome.com',
      //     'Bar Home - Contact',
      //     'contact',
      //     $context
      // );

      // accusé réception

      $messageBus->dispatch(
        new SendMailMessage(
          'contact@barhome.com',
          $contact->get('email')->getData(),
          "Bar Home - Nous avons bien reçu votre message",
          'message_confirmation',
          $context
        )
      );

      // $mail->send(
      //   'contact@barhome.com',
      //   $contact->get('email')->getData(),
      //   "Bar Home - Nous avons bien reçu votre message",
      //   'message_confirmation',
      //   $context
      // );

      $this->addFlash('success', 'Votre message a bien été envoyé !!');
      return $this->redirectToRoute('main');
    }

    return $this->render('main/contact.html.twig', [
      'contact_form' => $form->createView()
    ]);
  }

  #[Route('/bar/{slug}', name: 'show', methods: ["GET"])]
  public function show(Bar $bar): Response
  {
    $drinks = $bar->getDrinks();

    $drinksCategories = [];
    foreach ($drinks as $drink) {
      $drinksCategories[$drink->getCategory()][] = $drink;
    }

    ksort($drinksCategories);
    
    return $this->render('/main/show.html.twig', [
      'bar' => $bar,
      'categories' => $drinksCategories
    ]);
  }
}