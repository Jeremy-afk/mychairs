<?php

namespace App\Controller;

use App\Entity\Lounge;
use App\Entity\Chair;
use App\Form\LoungeType;
use App\Repository\LoungeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry; 
use App\Repository\ChairRepository; 


#[Route('/lounge')]
class LoungeController extends AbstractController
{
    #[Route('/', name: 'app_lounge_index', methods: ['GET'])]
    public function index(LoungeRepository $loungeRepository): Response
    {
        return $this->render('lounge/index.html.twig', [
            'lounges' => $loungeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lounge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lounge = new Lounge();
        $form = $this->createForm(LoungeType::class, $lounge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lounge);
            $entityManager->flush();

            return $this->redirectToRoute('app_lounge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lounge/new.html.twig', [
            'lounge' => $lounge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lounge_show', methods: ['GET'])]
    public function show(Lounge $lounge): Response
    {
        return $this->render('lounge/show.html.twig', [
            'lounge' => $lounge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lounge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lounge $lounge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LoungeType::class, $lounge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lounge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lounge/edit.html.twig', [
            'lounge' => $lounge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lounge_delete', methods: ['POST'])]
    public function delete(Request $request, Lounge $lounge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lounge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lounge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lounge_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #[Route("/{lounge_id}/chair/{chair_id}", name: "app_lounge_chair_show", methods: ["GET"])]
     
    public function chairShow(ManagerRegistry $doctrine, $lounge_id, $chair_id): Response
    {
        $loungeRepo = $doctrine->getRepository(Lounge::class);
        $lounge= $loungeRepo->find($lounge_id);
        $chairRepo = $doctrine->getRepository(Chair::class);
        $chair = $chairRepo->find($chair_id);

        if (!$chair) {
            throw $this->createNotFoundException('The chair does not exist');
        }
        if (!$lounge) {
            throw $this->createNotFoundException('The lounge does not exist');
        }

        if(! $lounge->getManytomany()->contains($chair)) {
            throw $this->createNotFoundException("Couldn't find such a [objet] in this [galerie]!");
        }

        if(! $lounge->isPublished()) {
                throw $this->createAccessDeniedException("You cannot access the requested ressource!");
        }

            return $this->render('lounge/chair_show.html.twig', [
                    'chair' => $chair,
                    'lounge' => $lounge
            ]);
    }
}
