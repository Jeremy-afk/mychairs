<?php

namespace App\Controller\Admin;

use App\Entity\Stack;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stack::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
