<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Address;
use App\Entity\Invoice;
use App\Entity\Meeting;
use App\Entity\Operation;
use App\Entity\Invitation;
use App\Controller\Admin\UsersCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UsersCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CleanThis');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Invitations', 'fas fa-envelope', Invitation::class);
        yield MenuItem::subMenu('Utilisateurs', 'fa fa-user')->setSubItems([
            MenuItem::linkToCrud('Clients', 'fa fa-arrow-right', Users::class)
                ->setQueryParameter('roles', '["ROLE_USER"]'),
                // ->setPermission('ROLE_ADMIN'), 
            MenuItem::linkToCrud('Employés', 'fa fa-arrow-right', Users::class)
                ->setQueryParameter('roles', '["ROLE_ADMIN"]')
        ]);
        yield MenuItem::linkToCrud('Adresses', 'fas fa-building', Address::class);
        yield MenuItem::linkToCrud('Rendez-vous', 'fas fa-calendar', Meeting::class);
        yield MenuItem::linkToCrud('Liste des opérations', 'fas fa-info-circle', Operation::class);
        yield MenuItem::linkToCrud('Factures', 'fas fa-file-invoice-dollar', Invoice::class);
        yield MenuItem::linkToRoute('Gestion de profil', 'fa fa-id-card', 'app_admin_profile');
        yield MenuItem::subMenu('Modification du profil', 'fas fa-bar')->setSubItems([
            MenuItem::linkToRoute('Mot de passe', 'fa fa-arrow-right', 'edit_admin_password'),
            MenuItem::linkToRoute('Coordonnées', 'fa fa-arrow-right', 'edit_admin_profile')
        ]);
        yield MenuItem::subMenu('Mes opérations', 'fas fa-bar')->setSubItems([]);
    }
}
