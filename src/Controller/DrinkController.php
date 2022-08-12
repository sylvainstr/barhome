<?php

namespace App\Controller;

use App\Entity\Drink;
use App\Form\DrinkType;
use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/monbar', name: 'bar_')]

class DrinkController extends AbstractController
{
  #[Route('/boisson/ajouter', name: 'drink_add', methods: ["GET", "POST"])]
    public function add(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if (empty($this->getUser())) {

            return $this->redirectToRoute('main');
        }

        $drink = new Drink();


        $drinkForm = $this->createForm(DrinkType::class, $drink);


        $drinkForm->handleRequest($request);


        if ($drinkForm->isSubmitted() && $drinkForm->isValid()) {

            $entityManager = $doctrine->getManager();

            $entityManager->persist($drink);
            $entityManager->flush();

            return $this->redirectToRoute('bar_browse');
        }


        return $this->render('/drink/add.html.twig', [
            'drink_form' => $drinkForm->createView(),
            'page' => 'create',
        ]);
    }

    #[Route('/boisson/modifier/{id}', name: 'drink_edit', methods: ["GET", "POST"])]
    public function edit(Request $request, Drink $drink, ManagerRegistry $doctrine): Response
    {
        if (empty($this->getUser())) {

            return $this->redirectToRoute('main');
        }

        $drinkForm = $this->createForm(DrinkType::class, $drink);

        $drinkForm->handleRequest($request);

        if ($drinkForm->isSubmitted() && $drinkForm->isValid()) {
            $entityManager = $doctrine->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('bar_browse');
        }

        // on fournit ce formulaire à notre vue
        return $this->render('/drink/add.html.twig', [
            'drink_form' => $drinkForm->createView(),
            'drink' => $drink,
            'page' => 'edit',
        ]);
    }

    #[Route('/boisson/supprimer/{id}', name: 'drink_delete', methods: ['GET'], requirements: ["id" => "\d+"])]
    public function delete(Drink $drink, EntityManagerInterface $entityManager): Response
    {
        if (empty($this->getUser())) {

            return $this->redirectToRoute('main');
        }

        $entityManager->remove($drink);
        $entityManager->flush();

        return $this->redirectToRoute('bar_browse');
    }
}
