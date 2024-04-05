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

                yield MenuItem::linkToRoute('statistique_label', 'fa-sharp fa-solid fa-chart-simple', 'app_admin_chart'), 

                yield MenuItem::section('opérations_label', 'fa-solid fa-folder-open'),
                yield MenuItem::linkToRoute('opérations_label', 'fa-solid fa-hand-sparkles', 'app_admin_operation'),
                yield MenuItem::linkToRoute('rendez-vous_label', 'fas fa-calendar', 'app_admin_meeting'),
                yield MenuItem::linkToRoute('factures_label', 'fas fa-file-invoice-dollar', 'app_admin_invoice'),

                yield MenuItem::section('mes_interventions_label', 'fa-brands fa-redhat'),
                yield MenuItem::linkToRoute('es_opérations_label', 'fa-solid fa-hand-sparkles', 'app_admin_myoperation'),
                yield MenuItem::linkToRoute('mes_rendez-vous_label', 'fas fa-calendar', 'app_admin_my_meetings'),
                yield MenuItem::linkToRoute('ma_facturation_label', 'fas fa-file-invoice-dollar', 'app_admin_myinvoices'),
                

                yield MenuItem::section('utilisateurs_label', 'fa-solid fa-users-line'),
                yield MenuItem::linkToCrud('invitations_label', 'fas fa-envelope', Invitation::class),
                yield MenuItem::subMenu('utilisateurs_label', 'fa-solid fa-users-rectangle')->setSubItems([
                    MenuItem::linkToCrud('clients_label', 'fa fa-arrow-right', Users::class)
                        ->setQueryParameter('job_title', 'Null'),
                    MenuItem::linkToCrud('employés_label', 'fa fa-arrow-right', Users::class)
                        ->setController(EmployeeCrudController::class)
                        ->setQueryParameter('job_title', 'Opérateur')
                ]),
                yield MenuItem::linkToCrud('adresses_label', 'fas fa-address-book', Address::class),

                yield MenuItem::section('mon_profil_label', 'fa-solid fa-screwdriver-wrench'),
                yield MenuItem::linkToRoute('gestion_de_profil_label', 'fa fa-id-card', 'app_admin_profile'),
                yield MenuItem::subMenu('modification_du_profil_label', 'fas fa-bar')->setSubItems([
                    MenuItem::linkToRoute('mot_de_passe_label', 'fa fa-arrow-right', 'edit_admin_password'),
                    MenuItem::linkToRoute('coordonnées_label', 'fa fa-arrow-right', 'edit_admin_profile')
                ]),
                yield MenuItem::section('mon_historique_label', 'fa-solid fa-clock-rotate-left'),
                yield MenuItem::linkToRoute('mes_opérations_label', 'fa-solid fa-hand-sparkles', 'app_admin_my_past_operation'),
                yield MenuItem::linkToRoute('mes_rendez-vous_label', 'fas fa-calendar', 'app_admin_my_meeting'), 
                yield MenuItem::linkToRoute('ma_facturation_label', 'fas fa-file-invoice-dollar', 'app_admin_myinvoicess')
                

            ];
        } else {
            return [
                yield MenuItem::section('opérations_label', 'fa-solid fa-folder-open'),
                yield MenuItem::linkToRoute('opérations_label', 'fa-solid fa-hand-sparkles', 'app_admin_operation'),
                yield MenuItem::linkToRoute('rendez-vous_label', 'fas fa-calendar', 'app_admin_meeting'),
                yield MenuItem::linkToRoute('factures_label', 'fas fa-file-invoice-dollar', 'app_admin_invoice'),

                yield MenuItem::section('mes_interventions_label', 'fa-brands fa-redhat'),
                yield MenuItem::linkToRoute('mes_rendez-vous_label', 'fas fa-calendar', 'app_admin_my_meetings'), 
                yield MenuItem::linkToRoute('mes_opérations_label', 'fa-solid fa-hand-sparkles', 'app_admin_myoperation'),
                yield MenuItem::linkToRoute('ma_facturation_label', 'fas fa-file-invoice-dollar', 'app_admin_myinvoices'),

                yield MenuItem::section('utilisateurs_label', 'fa-solid fa-users-line'),
                yield MenuItem::subMenu('utilisateurs_label', 'fa-solid fa-users-rectangle')->setSubItems([
                    MenuItem::linkToCrud('clients_label', 'fa fa-arrow-right', Users::class)
                        ->setQueryParameter('job_title', 'Null'),
                    MenuItem::linkToCrud('employés_label', 'fa fa-arrow-right', Users::class)
                        ->setController(EmployeeCrudController::class)
                        ->setQueryParameter('job_title', 'Opérateur')
                ]),
                yield MenuItem::linkToCrud('adresses_label', 'fas fa-address-book', Address::class),

                yield MenuItem::section('mon_profil_label', 'fa-solid fa-screwdriver-wrench'),
                yield MenuItem::linkToRoute('gestion_de_profil_label', 'fa fa-id-card', 'app_admin_profile'),
                yield MenuItem::subMenu('modification_du_profil_label', 'fas fa-bar')->setSubItems([
                    MenuItem::linkToRoute('mot_de_passe_label', 'fa fa-arrow-right', 'edit_admin_password'),
                    MenuItem::linkToRoute('coordonnées_label', 'fa fa-arrow-right', 'edit_admin_profile')
                ]),
                yield MenuItem::section('mon_historique_label', 'fa-solid fa-clock-rotate-left'),
                yield MenuItem::linkToRoute('mes_rendez-vous_label', 'fas fa-calendar', 'app_admin_my_meeting'), 
                yield MenuItem::linkToRoute('mes_opérations_label', 'fa-solid fa-hand-sparkles', 'app_admin_my_past_operation'),
                yield MenuItem::linkToRoute('ma_facturation_label', 'fas fa-file-invoice-dollar', 'app_admin_myinvoicess')

            ];
        }

    }
}
