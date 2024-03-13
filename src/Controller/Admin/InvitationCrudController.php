<?php

namespace App\Controller\Admin;

use App\Form\RoleType;
use App\Entity\Invitation;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InvitationCrudController extends AbstractCrudController
{
    use trait\CreateReadTrait;
    protected $mail;

    public function __construct(SendMailService $mail)
    {
        $this->mail = $mail;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);
        $uuid =  $entityInstance->getUuid();;
        $url = $this->generateUrl('app_invitation', ['uuid' => $uuid], UrlGeneratorInterface::ABSOLUTE_URL);
        $context = compact('url', 'entityInstance');
        $this->mail->send(
            'acleanthis@gmail.com',
            $entityInstance->getEmail(),
            'Création de votre compte professionel',
            'invitation',
            $context
        );
    }

    public static function getEntityFqcn(): string
    {
        return Invitation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'Nouvel employé par invitation');
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            EmailField::new('email', ('E-mail')),
            TextField::new('uuid', ('Clé Uuid'))
                ->hideWhenCreating(),
            AssociationField::new('employee', ('Employé'))
                ->hideWhenCreating(),
            ChoiceField::new('roles', ('Poste'))->setChoices([
                'Poste' => [
                    'Apprenti' => 'ROLE_APPRENTI',
                    'Senior' => 'ROLE_SENIOR',
                    'Expert' => 'ROLE_EXPERT'
                ]
            ])
        ];
    }
}
