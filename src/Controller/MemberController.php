<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Member;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'app_member')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Member::class);
        $members = $repository->findAll();
    
        return $this->render('/member/index.html.twig',
            ['members' =>$members]);
    }

    #[Route('/member/{id}', name: 'member_show', requirements: ['id' => '\d+'])]
    public function show(EntityManagerInterface $doctrine, $id)
    {
        $memberRepo = $doctrine->getRepository(Member::class);
        $member = $memberRepo->find($id);
        return $this->render('/member/show.html.twig',
            [ 'member' => $member]           

        );
    }
}
