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
use App\Controller\Admin\EmployeeCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    /**
     * @author Florent <bflorent53170@gmail.com>
     */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OperationCrudController::class)->generateUrl());
         return $this->redirect('/admin?routeName=app_admin_operation', 301); 
    }

    public function configureAssets(): Assets     
    {         return parent::configureAssets()             
                ->addCssFile('css/sidebarstyle.css');     
    }

    /**
     * @author Nacim <nacim.ouldrabah@gmail.com>
     *
     * @return Dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('<img src="assets/images/Logo.png" class="img-fluid d-block mx-auto" style="max-width:100px; width:100%; ">');
    }


    /**
     * @author Florent <bflorent53170@gmail.com>
     * @author Nacim <nacim.ouldrabah@gmail.com>
     *
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {

        if ($this->isGranted("ROLE_ADMIN") or $this->isGranted("ROLE_EXPERT")) {
            return [

                yield MenuItem::linkToRoute('Statistique', 'fa-sharp fa-solid fa-chart-simple', 'app_admin_chart'), 

                yield MenuItem::section('Opérations', 'fa-solid fa-folder-open'),
                yield MenuItem::linkToRoute('Opérations', 'fa-solid fa-hand-sparkles', 'app_admin_operation'),
                yield MenuItem::linkToRoute('Rendez-vous', 'fas fa-calendar', 'app_admin_meeting'),
                yield MenuItem::linkToCrud('Factures', 'fas fa-file-invoice-dollar', Invoice::class),

                yield MenuItem::section('Mes interventions', 'fa-brands fa-redhat'),
                yield MenuItem::linkToRoute('Mes rendez-vous', 'fas fa-calendar', 'app_admin_my_meetings'), 
                yield MenuItem::linkToRoute('Mes opérations', 'fa-solid fa-hand-sparkles', 'app_admin_myoperation'),
                yield MenuItem::linkToRoute('Ma facturation', 'fas fa-file-invoice-dollar', Invoice::class),
                

                yield MenuItem::section('Utilisateurs', 'fa-solid fa-users-line'),
                yield MenuItem::linkToCrud('Invitations', 'fas fa-envelope', Invitation::class),
                yield MenuItem::subMenu('Utilisateurs', 'fa-solid fa-users-rectangle')->setSubItems([
                    MenuItem::linkToCrud('Clients', 'fa fa-arrow-right', Users::class)
                        ->setQueryParameter('job_title', 'Null'),
                    MenuItem::linkToCrud('Employés', 'fa fa-arrow-right', Users::class)
                        ->setController(EmployeeCrudController::class)
                        ->setQueryParameter('job_title', 'Opérateur')
                ]),
                yield MenuItem::linkToCrud('Adresses', 'fas fa-address-book', Address::class),

                yield MenuItem::section('Mon profil', 'fa-solid fa-screwdriver-wrench'),
                yield MenuItem::linkToRoute('Gestion de profil', 'fa fa-id-card', 'app_admin_profile'),
                yield MenuItem::subMenu('Modification du profil', 'fas fa-bar')->setSubItems([
                    MenuItem::linkToRoute('Mot de passe', 'fa fa-arrow-right', 'edit_admin_password'),
                    MenuItem::linkToRoute('Coordonnées', 'fa fa-arrow-right', 'edit_admin_profile')
                ]),
                yield MenuItem::section('Mon historique', 'fa-solid fa-clock-rotate-left'),
                yield MenuItem::linkToRoute('Mes rendez-vous', 'fas fa-calendar', 'app_admin_my_meeting'), 
                yield MenuItem::linkToRoute('Mes opérations', 'fa-solid fa-hand-sparkles', Operation::class),
                yield MenuItem::linkToRoute('Ma facturation', 'fas fa-file-invoice-dollar', Invoice::class)
                

            ];
        } else {
            return [
                yield MenuItem::section('Opérations', 'fa-solid fa-folder-open'),
                yield MenuItem::linkToRoute('Liste des opérations', 'fa-solid fa-hand-sparkles','app_admin_operation'),
                yield MenuItem::linkToRoute('Rendez-vous', 'fas fa-calendar', 'app_admin_meeting'),
                yield MenuItem::linkToCrud('Factures', 'fas fa-file-invoice-dollar', Invoice::class),

                yield MenuItem::section('Utilisateurs', 'fa-solid fa-users-line'),
                yield MenuItem::subMenu('Utilisateurs', 'fa-solid fa-users-rectangle')->setSubItems([
                    MenuItem::linkToCrud('Clients', 'fa fa-arrow-right', Users::class)
                        ->setQueryParameter('job_title', 'Null'),
                    MenuItem::linkToCrud('Employés', 'fa fa-arrow-right', Users::class)
                        ->setController(EmployeeCrudController::class)
                        ->setQueryParameter('job_title', 'Opérateur')
                ]),
                yield MenuItem::linkToCrud('Adresses', 'fas fa-address-book', Address::class),

                yield MenuItem::section('Mon profil', 'fa-solid fa-screwdriver-wrench'),
                yield MenuItem::linkToRoute('Gestion de profil', 'fa fa-id-card', 'app_admin_profile'),
                yield MenuItem::subMenu('Modification du profil', 'fas fa-bar')->setSubItems([
                    MenuItem::linkToRoute('Mot de passe', 'fa fa-arrow-right', 'edit_admin_password'),
                    MenuItem::linkToRoute('Coordonnées', 'fa fa-arrow-right', 'edit_admin_profile')
                ]),
                yield MenuItem::subMenu('Mes opérations', 'fas fa-bar')->setSubItems([]),

            ];
        }

    }
}
