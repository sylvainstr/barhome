<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Form\BarType;
use App\Repository\BarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/monbar', name: 'bar_')]

class BarController extends AbstractController
{
    #[Route('', name: 'browse')]
    public function mybar(BarRepository $bar): Response
    {

        $bar = $bar->findAll();

        return $this->render('bar/browse.html.twig', [
            'bar_browse' => $bar
        ]);
    }

    #[Route('/ajouter', name: 'add', methods: ["GET", "POST"])]
    public function add(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        if (empty($this->getUser())) {

            return $this->redirectToRoute('main');
        }

        $bar = new Bar();


        $barForm = $this->createForm(BarType::class, $bar);


        $barForm->handleRequest($request);


        if ($barForm->isSubmitted() && $barForm->isValid()) {

            $entityManager = $doctrine->getManager();

            $entityManager->persist($bar);
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
        if (empty($this->getUser())) {

            return $this->redirectToRoute('main');
        }

        $barForm = $this->createForm(BarType::class, $bar);

        $barForm->handleRequest($request);

        if ($barForm->isSubmitted() && $barForm->isValid()) {
            $entityManager = $doctrine->getManager();

            $entityManager->flush();

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
