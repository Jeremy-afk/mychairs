<?php

namespace App\Controller\Admin;

use App\Entity\Chair;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ChairCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chair::class;
    }

   
    public function configureFields(string $chair): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextEditorField::new('description'),
        ];
    }
   
}
