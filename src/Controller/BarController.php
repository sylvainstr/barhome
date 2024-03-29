<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Entity\User;
use App\Form\BarType;
use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/monbar', name: 'bar_')]

class BarController extends AbstractController
{
    #[Route('', name: 'browse')]
    public function mybar(DrinkRepository $drinksRepo): Response
    {
        /** @var User */
        $user = $this->getUser();
        $bar = $user->getBar();

        $drinks = $drinksRepo->findByBarCategory($bar);

        $drinksCategories = [];
        foreach ($drinks as $drink) {
            $drinksCategories[$drink->getCategory()][] = $drink;
        }

        return $this->render('bar/browse.html.twig', [
            'categories' => $drinksCategories
        ]);
    }

    #[Route('/ajouter', name: 'add', methods: ["GET", "POST"])]
    public function add(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if (empty($this->getUser())) {

            return $this->redirectToRoute('main');
        }
        /** @var User */
        $user = $this->getUser();
        if ($user->getBar()) {
            $this->addFlash('error', "Un bar existe déjà !!");

            return $this->redirectToRoute('bar_browse');
        }

        $bar = new Bar();


        $barForm = $this->createForm(BarType::class, $bar);


        $barForm->handleRequest($request);


        if ($barForm->isSubmitted() && $barForm->isValid()) {

            $entityManager = $doctrine->getManager();
            /** @var User */
            $user = $this->getUser();

            $bar->setUser($user);

            $entityManager->persist($bar);

            $entityManager->persist($user);

            $entityManager->flush();

            return $this->redirectToRoute('bar_browse');
        }


        return $this->render('/bar/add.html.twig', [
            'bar_form' => $barForm->createView(),
            'page' => 'create',
        ]);
    }

    #[Route('/modifier/{id}', name: 'edit', methods: ["GET", "POST"])]
    public function edit(Request $request, Bar $bar, ManagerRegistry $doctrine): Response
    {

        /** @var User */
        $user = $this->getUser();

        if (empty($this->getUser())) {

            return $this->redirectToRoute('main');
        }

        $barForm = $this->createForm(BarType::class, $bar);

        $barForm->handleRequest($request);

        if ($barForm->isSubmitted() && $barForm->isValid()) {
            $entityManager = $doctrine->getManager();

            $entityManager->flush();

            // si l'image QR code existe, on supprime l'image QR code

            $namePng = $user->getCryptedId() . '.png';

            $filesystem = new Filesystem();

            $fileName = \dirname(path: __DIR__, levels: 2) . '/public/assets/qr-code/' . $namePng;

            // Création de l'image QRcode
            if ($filesystem->exists($fileName)) {

                $filesystem->remove($fileName);
            }



            return $this->redirectToRoute('bar_browse');
        }

        // on fournit ce formulaire à notre vue
        return $this->render('/bar/add.html.twig', [
            'bar_form' => $barForm->createView(),
            'bar' => $bar,
            'page' => 'edit',
        ]);
    }


    #[Route('/supprimer/{id}', name: 'delete', methods: ['GET'], requirements: ["id" => "\d+"])]
    public function delete(Bar $bar, EntityManagerInterface $entityManager): Response
    {
        if (empty($this->getUser())) {

            return $this->redirectToRoute('main');
        }

        $entityManager->remove($bar);
        $entityManager->flush();

        return $this->redirectToRoute('bar_browse');
    }
}
