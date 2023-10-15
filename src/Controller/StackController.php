<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chair; 
use App\Entity\Stack;

class StackController extends AbstractController
{
    #[Route('/stack', name: 'app_stack')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérez les éléments depuis la table "Stack" dans la base de données
        $repository = $entityManager->getRepository(Stack::class);
        $stacks = $repository->findAll();
    
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
            [ 'welcome' => "Bonne utilisation de la todo list",
              'stack' => $stack]           

        );
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
    }
    
}
