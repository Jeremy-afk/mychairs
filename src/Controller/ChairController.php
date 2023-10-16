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
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Chair::class);
        $chairs = $repository->findAll();
    
        return $this->render('/chair/index.html.twig',
            ['chairs' =>$chairs]);
    }

    #[Route('/chair/{id}', name: 'chair_show', requirements: ['id' => '\d+'])]
    public function show(EntityManagerInterface $doctrine, $id)
    {
        $chairRepo = $doctrine->getRepository(Chair::class);
        $chair = $chairRepo->find($id);
        return $this->render('/chair/show.html.twig',
            ['chair' => $chair]           

        );
    }
}