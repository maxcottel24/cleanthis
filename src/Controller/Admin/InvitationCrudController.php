<?php

namespace App\Controller\Admin;

use App\Entity\Invitation;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InvitationCrudController extends AbstractCrudController
{
    use Trait\CreateReadTrait;
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
