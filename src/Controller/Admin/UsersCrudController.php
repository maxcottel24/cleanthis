<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;

class UsersCrudController extends AbstractCrudController
{
    use Trait\ReadDeleteTrait;

    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            ArrayField::new('roles'),
            TextField::new('lastname'),
            TextField::new('firstname'),
            EmailField::new('email'),
            AssociationField::new('addresses')
                ->onlyOnIndex(),
            ArrayField::new('addresses')
                ->onlyOnDetail(),
            AssociationField::new('meetings')
                ->onlyOnIndex(),
            ArrayField::new('meetings')
                ->onlyOnDetail(),
            TelephoneField::new('phone_number'),
            DateField::new('date_of_birthday')
                ->onlyOnDetail(),
        ];
    }
}
