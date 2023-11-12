<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chair; 
use App\Entity\Stack;
use App\Entity\Member;


use App\Form\StackType;
use App\Repository\StackRepository;


class StackController extends AbstractController
{
    #[Route('/stack', name: 'app_stack')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérez les éléments depuis la table "Stack" dans la base de données
        $repository = $entityManager->getRepository(Stack::class);
        $stacks = $repository->findAll();
    
        return $this->render('/stack/index.html.twig',
            ['stacks' =>$stacks]);
     
    } 

    /*
     * Show a Stack
     *
     * @param Integer $id (note that the id must be an integer)
    */
    
    #[Route('/stack/{id}', name: 'stack_show', requirements: ['id' => '\d+'])]
    public function show(EntityManagerInterface $doctrine, $id)
    {
        $stackRepo = $doctrine->getRepository(Stack::class);
        $stack = $stackRepo->find($id);
        return $this->render('/stack/show.html.twig',
            [ 'stack' => $stack]           

        );
    }


    #[Route('/new', name: 'app_stack_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stack = new Stack();

        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stack);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_stack', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('stack/new.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    #[Route('/new/{id}', name: 'app_stack_new_with_member', methods: ['GET', 'POST'])]
    public function newWithMember(Request $request, EntityManagerInterface $entityManager, Member $member): Response
    {
        $stack = new Stack();
        $stack->setMember($member);
        
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stack);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_stack', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('stack/new.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stack_delete', methods: ['POST'])]
    public function delete(Request $request, Stack $stack, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stack->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stack', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_stack_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stack $stack, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stack', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stack/edit.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }
    
}
