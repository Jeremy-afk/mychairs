<?php

namespace App\Controller\Admin;

use App\Entity\Stack;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;


class StackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stack::class;
    }

 
    public function configureFields(string $stack): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextEditorField::new('description'),
            AssociationField::new('chairsInStack')
        ];
    }
   
}
