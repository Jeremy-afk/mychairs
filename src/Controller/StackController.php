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
/*        
        // Générez le contenu HTML à partir de la liste des "Stacks"
        $htmlContent = '<html>
          <body>Liste des Stacks :
            <ul>';
        
        foreach ($stacks as $stack) {
            $url = $this->generateUrl(
                'stack_show',
                ['id' => $stack->getId()] // Assurez-vous que votre entité Stack a une méthode getId() pour obtenir l'ID
            );        
            $htmlContent .= '<li><a href="' . $url . '">' . $stack->getName() . ' (' . $stack->getId() . ')</a></li>';
            // Assurez-vous d'adapter cette ligne en fonction des propriétés de votre classe Stack
        }
        
        $htmlContent .= '</ul>
          </body>
        </html>';
    
        // Retournez la réponse HTTP contenant le contenu HTML
        return new Response($htmlContent);
*/       
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
        /*
        $stackRepo = $doctrine->getRepository(Stack::class);
        $stack = $stackRepo->find($id);

        if (!$stack) {
            throw $this->createNotFoundException('The Stack does not exist');
        }

        $res = '<html><body>'; // Ouvrez les balises HTML ici

        // Vous pouvez maintenant ajouter du contenu HTML à $res en fonction des propriétés de votre Stack
        $res .= '<h1>' . $stack->getName() . '</h1>'; // Remplacez getNom() par la méthode appropriée de votre Stack
        $res .= '<p>' . $stack->getDescription() . '</p>'; // Remplacez getDescription() par la méthode appropriée
        $res .= '<p>' . $stack->isIsPublic() . " (1 public 0 privée)". '</p>'; 
        $chairs = $stack->getChairsInStack();

        foreach ($chairs as $chair) {
            $name = $chair -> getName();
            $description = $chair -> getDescription();
            $type = $chair -> getType();
            $nbLegs = $chair -> getNbLegs();
            $rarity = $chair -> getRarity();
            
            $res .= '<p>' ."Nom : ".  $name ." Description : ".  $description . " Type : ". $type . " Nombre de pieds : ". $nbLegs . " Rareté : ". $rarity . '</p>';
        }
        

        // Ajoutez d'autres informations de votre Stack ici

        //$res .= '<p/><a href="' . $this->generateUrl('stack_index') . '">Back</a>';
        $res .= '</body></html>'; // Fermez les balises HTML ici

        return new Response($res);
        */

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
