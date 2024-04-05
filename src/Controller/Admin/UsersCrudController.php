<?php

namespace App\Controller\Admin;

use App\Entity\Users;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

/**
 * @author Florent <bflorent53170@gmail.com>
 */
class UsersCrudController extends AbstractCrudController
{
    use Trait\CreateReadTrait;

    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'list_customers_label');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $statusFilter = $this->getContext()->getRequest()->query->get('job_title');
        if ($statusFilter) {
            $qb->andWhere('entity.job_title = :job_title')->setParameter('job_title', $statusFilter);
        }

        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideWhenCreating()
                ->hideOnIndex()
                ->hideOnDetail(),
            ArrayField::new('roles')
                ->hideWhenCreating()
                ->hideOnIndex()
                ->hideOnDetail()
                , 
            TextField::new('lastname', ('lastname_label')),
            TextField::new('firstname', ('firstname_label')),
            EmailField::new('email', ('email_label')),
            AssociationField::new('addresses', ('addresses_label'))
                ->onlyOnIndex(),
            ArrayField::new('addresses', ('addresses_label'))
                ->onlyOnDetail(),
            AssociationField::new('meetings', ('meetings_label'))
                ->onlyOnIndex(),
            ArrayField::new('meetings', ('meetings_label'))
                ->onlyOnDetail(),
            TelephoneField::new('phone_number', ('phone_label')),
            DateField::new('date_of_birthday', ('birthday_label'))
                ->onlyOnDetail(),
        ];
    }

}
