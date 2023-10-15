<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chair; 
use App\Entity\Stack;

class ChairController extends AbstractController
{
    #[Route('/chair', name: 'app_chair')]
    public function index(): Response
    {
        return $this->render('chair/index.html.twig', [
            'controller_name' => 'ChairController',
        ]);
    }

    #[Route('/chair/{id}', name: 'chair_show', requirements: ['id' => '\d+'])]
    public function show(EntityManagerInterface $doctrine, $id)
    {
        $chairRepo = $doctrine->getRepository(Chair::class);
        $chair = $chairRepo->find($id);
        return $this->render('/chair/show.html.twig',
            [ 'welcome' => "Bonne utilisation de la todo list",
              'chair' => $chair]           

        );
    }
}