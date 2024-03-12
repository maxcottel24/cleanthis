<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use trait\ReadOnlyTrait;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EmployeeCrudController extends UsersCrudController
{
    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des employés');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW, Action::EDIT)
                ->add(Crud::PAGE_INDEX, Action::DETAIL)
                ->setPermission(Action::DELETE, 'ROLE_ADMIN')
                ->update(Crud::PAGE_INDEX, Action::NEW, function(Action $actions){
                    return $actions->setIcon('fa fa-file-alt')->setLabel(false);
                })
        ;

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ArrayField::new('roles', ('Poste')),
            TextField::new('lastname', ('Nom')),
            TextField::new('firstname', ('Prénom')),
            EmailField::new('email', ('E-mail')),
            ArrayField::new('addresses', ('Adresse'))
                ->onlyOnDetail(),
            AssociationField::new('meetings', ('Rendez-vous'))
                ->onlyOnIndex(),
            ArrayField::new('meetings', ('Rendez-vous'))
                ->onlyOnDetail(),
            TelephoneField::new('phone_number', ('Téléphone')),
            DateField::new('date_of_birthday', ('Date de naissance'))
                ->onlyOnDetail(),
        ];
    }
}