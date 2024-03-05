<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Address;
use App\Entity\Invitation;
use App\Entity\Invoice;
use App\Entity\Meeting;
use App\Entity\Operation;
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
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', Users::class);
        yield MenuItem::linkToCrud('Adresses', 'fas fa-building', Address::class);
        yield MenuItem::linkToCrud('Rendez-vous', 'fas fa-info-circle', Meeting::class);
        yield MenuItem::linkToCrud('Liste des opérations', 'fas fa-info-circle', Operation::class);
        yield MenuItem::linkToCrud('Factures', 'fas fa-info-circle', Invoice::class);
        yield MenuItem::linkToRoute('Profil', 'fa fa-id-card', 'edit_admin_profile');
    }
}
