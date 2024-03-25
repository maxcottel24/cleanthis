<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class AddressCrudController extends AbstractCrudController
{

    use Trait\CreateEditTrait;

    /**
     * @author Florent <bflorent53170@gmail.com>
     *
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }


    /**
     * @author NFlorent <bflorent53170@gmail.com>
     */
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des adresses');
    }


    /**
     * @author Florent <bflorent53170@gmail.com>
     * @author Nacim <nacim.ouldrabah@gmail.com>
     * @author Efflam <cefflam@gmail.com>
     *
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user', ('Utilisateur')),
            TextField::new('street', ('Rue')),
            TextField::new('zipcode', ('Code postale')),
            TextField::new('city', ('Ville')),
            ChoiceField::new('is_primary', ('Définir'))->setChoices([
                'choices' => [
                    'Secondaire' => 0,
                    'Principale' => 1,
                ]
            ])
        ];
    }
}
