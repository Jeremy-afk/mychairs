<?php

namespace App\Controller\Admin;

use App\Entity\Chair;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

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
            IntegerField::new('nbLegs'),
            TextField::new('rarity'),
        ];
    }
   
}
