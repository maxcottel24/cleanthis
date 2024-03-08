<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UsersCrudController extends AbstractCrudController
{
    use Trait\ReadDeleteTrait;

    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
    
        $statusFilter = $this->getContext()->getRequest()->query->get('roles');
        if ($statusFilter) {
            $qb->andWhere('entity.roles = :roles')->setParameter('roles', $statusFilter);
        }
    
        return $qb;
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
