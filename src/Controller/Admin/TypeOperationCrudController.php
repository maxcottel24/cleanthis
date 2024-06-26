<?php

namespace App\Controller\Admin;

use App\Entity\TypeOperation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


/**
 * @author Florent <bflorent53170@gmail.com>
 */
class TypeOperationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeOperation::class;
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
