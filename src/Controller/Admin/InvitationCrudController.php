<?php

namespace App\Controller\Admin;

use App\Entity\Invitation;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InvitationCrudController extends AbstractCrudController
{
    use Trait\CreateReadTrait;

    public static function getEntityFqcn(): string
    {
        return Invitation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            TextField::new('uuid')
                ->hideWhenCreating(),
            AssociationField::new('employee')
                ->hideWhenCreating()
        ];
    }
}
