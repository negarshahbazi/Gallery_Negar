<?php

namespace App\Controller\Admin;

use App\Entity\Paint;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PaintCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Paint::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title'),
            IdField::new('sizeW'),
            IdField::new('sizeH'),
            IdField::new('sizeD'),
            IdField::new('price'),
            TextField::new('typeOfWork'),
            IdField::new('gradeCount'),
            IdField::new('gradeTotal'),
            BooleanField::new('available'),


            ////////////////////////////////////// relations /////////////////////////////////////////////////////////////
            AssociationField::new('photo'),
            AssociationField::new('category'),
           

        ];
    }
}
