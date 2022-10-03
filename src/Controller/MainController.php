<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Form\ContactType;
use App\Message\SendMailMessage;
use App\Service\SendMailService;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

  private $builder;

  public function __construct(BuilderInterface $builder)
  {
    $this->builder = $builder;
  }

  #[Route('/qrcode', name: 'qrcode', methods: ["GET"])]
  public function qrcode(): Response
  {
    /** @var User */
    $user = $this->getUser();

    $qrCode = null;

    $objDateTime = new \DateTime(datetime: 'now');
    $dataString = $objDateTime->format(format: 'd-m-Y');



    $url = $this->generateUrl('show', [
      'slug' => $user->getBar()->getSlug()
    ], UrlGeneratorInterface::ABSOLUTE_URL);

    // $url = "https://www.barhome.fr/qrcode/";

    // set le qrcode
    $result = $this->builder
      ->data(data: $url)
      ->encoding(new Encoding('UTF-8'))
      ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
      ->size(400)
      ->margin(10)
      // ->labelText($dataString)
      ->build();

    // génére le name
    // $namePng = uniqid(prefix: '', more_entropy:'') . '.png';

    $namePng = $user->getCryptedId() . '.png';

    $filesystem = new Filesystem();

    $fileName = \dirname(path: __DIR__, levels: 2) . '/public/assets/qr-code/' . $namePng;

    // Création de l'image QRcode
    if (!$filesystem->exists($fileName)) {
      $result->saveToFile($fileName);

      // récupérer l'url de l'image
      // $qrCode = $result->getDataUri();
    }

    // header('Content-Type: '.$result->getMimeType());
    // echo $result->getString();

    return $this->render('/main/qrcode.html.twig', [
      'qrCode' => 'assets/qr-code/' . $namePng
    ]);
  }
}
