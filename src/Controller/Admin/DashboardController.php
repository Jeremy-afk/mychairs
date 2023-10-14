<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use App\Entity\Stack;
use App\Entity\Chair;
use App\Entity\Member;

class DashboardController extends AbstractDashboardController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $stacks = $this->entityManager->getRepository(Stack::class)->findAll();
        
        $maxChairCount = 0;
        foreach ($stacks as $stack) {
            $currentChairCount = count($stack->getChairsInStack());
            if ($currentChairCount > $maxChairCount) {
                $maxChairCount = $currentChairCount;
            }
        }
        return $this->render('admin/my-dashboard.html.twig', [
            'stacks' => $stacks,
            'maxChairCount' => $maxChairCount,
        ]);
    }

    public function configureMenuItems(): iterable
    {
        return  [
        MenuItem::linkToCrud('Chairs', 'fa fa-chair', Chair::class),
        MenuItem::linkToCrud('Add Chair', 'fa fa-plus', Chair::class)
            ->setAction('new'),
        MenuItem::linkToCrud('Stack', 'fa fa-stack', Stack::class),
        MenuItem::linkToCrud('Add Stack', 'fa fa-plus', Stack::class)
            ->setAction('new'),
            
        MenuItem::linkToCrud('Members', 'fa fa-member', Member::class),
        MenuItem::linkToCrud('Add Member', 'fa fa-plus', Member::class)
            ->setAction('new'),
        //MenuItem::linkToLogout('Logout', 'fa fa-exit'),
        
       ];
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {

        return parent::configureUserMenu($user)
        ->setName($user->getFullName())
        ->displayUserName(false);

    }

    
    
}
