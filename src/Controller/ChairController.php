<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chair; 
use App\Entity\Stack;

use App\Form\ChairType;

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

    #[Route('/new', name: 'app_chair_new_with_stack', methods: ['GET', 'POST'])]
    public function newWithStack(Request $request, EntityManagerInterface $entityManager, Stack $stack): Response
    {
        $chair = new Chair();
        $chair->setStack($stack);
        
        $form = $this->createForm(ChairType::class, $chair);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chair);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_chair', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('chair/new.html.twig', [
            'chair' => $chair,
            'form' => $form,
        ]);
    }
}