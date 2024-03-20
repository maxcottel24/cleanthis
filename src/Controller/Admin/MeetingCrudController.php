<?php

namespace App\Controller\Admin;

use App\Entity\Meeting;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use phpDocumentor\Reflection\PseudoTypes\True_;

/**
 * @author Florent <bflorent53170@gmail.com>
 */
class MeetingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Meeting::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des rendez-vous')
            ->showEntityActionsInlined(); 
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('reserved_at', ('Date & Heure'))
                ->setTimezone('Europe/Paris')
                ->setFormat('dd MMM YYYY HH:mm'),
            ChoiceField::new('status', ('Etat'))
                ->setChoices([
                        'A traiter' => '1',
                        'En cours' => '2',
                        'Pris en charge' => '3',
                        'Retour client' => '4'
                ])
                ->renderAsBadges([
                    '1' => 'danger',
                    '2' => 'primary',
                    '3' => 'success',
                    '4' => 'warning'
                ]),
            AssociationField::new('users', ('Client / Opérateur'))
                ->autocomplete(false)
                ->hideOnIndex(), 
            AssociationField::new('address', 'Adresse'),
            NumberField::new('floor_space', ('Surface(m²)')),
            TextEditorField::new('description')
                ->onlyOnIndex(),
            TextareaField::new('description', ('Description'))
                ->renderAsHtml()
                ->onlyOnForms()

        ];
    }
}
