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
        // ->setTitle('<img src="assets/images/Logo.jpg" class="img-fluid d-block mx-auto" style="max-width:100px; width:100%; "> CleanThis');
        ->setTitle('<span style="color:white;">Clean</span><span style="color:#2A56A1; ">This</span>');
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

                yield MenuItem::section('operations_label', 'fa-solid fa-folder-open'),
                yield MenuItem::linkToRoute('operations_label', 'fa-solid fa-hand-sparkles', 'app_admin_operation'),
                yield MenuItem::linkToRoute('meetings_label', 'fas fa-calendar', 'app_admin_meeting'),
                yield MenuItem::linkToRoute('invoices_label', 'fas fa-file-invoice-dollar', 'app_admin_invoice'),

                yield MenuItem::section('my_interventions_label', 'fa-brands fa-redhat'),
                yield MenuItem::linkToRoute('my_operations_label', 'fa-solid fa-hand-sparkles', 'app_admin_myoperation'),
                yield MenuItem::linkToRoute('my_meetings_label', 'fas fa-calendar', 'app_admin_my_meetings'),
                yield MenuItem::linkToRoute('my_invoices_label', 'fas fa-file-invoice-dollar', 'app_admin_myinvoices'),
                

                yield MenuItem::section('users_label', 'fa-solid fa-users-line'),
                yield MenuItem::linkToCrud('invitations_label', 'fas fa-envelope', Invitation::class),
                yield MenuItem::subMenu('users_label', 'fa-solid fa-users-rectangle')->setSubItems([
                    MenuItem::linkToCrud('customers_label', 'fa fa-arrow-right', Users::class)
                        ->setQueryParameter('job_title', 'Null'),
                    MenuItem::linkToCrud('employees_label', 'fa fa-arrow-right', Users::class)
                        ->setController(EmployeeCrudController::class)
                        ->setQueryParameter('job_title', 'Opérateur')
                ]),
                yield MenuItem::linkToCrud('addresses_label', 'fas fa-address-book', Address::class),

                yield MenuItem::section('my_profile_label', 'fa-solid fa-screwdriver-wrench'),
                yield MenuItem::linkToRoute('control_my_profile_label', 'fa fa-id-card', 'app_admin_profile'),
                yield MenuItem::subMenu('modify_my_profile_label', 'fas fa-bar')->setSubItems([
                    MenuItem::linkToRoute('password_label', 'fa fa-arrow-right', 'edit_admin_password'),
                    MenuItem::linkToRoute('contact_label', 'fa fa-arrow-right', 'edit_admin_profile')
                ]),
                yield MenuItem::section('my_history_label', 'fa-solid fa-clock-rotate-left'),
                yield MenuItem::linkToRoute('my_operations_label', 'fa-solid fa-hand-sparkles', 'app_admin_my_past_operation'),
                yield MenuItem::linkToRoute('my_meetings_label', 'fas fa-calendar', 'app_admin_my_meeting'), 
                yield MenuItem::linkToRoute('my_invoices_label', 'fas fa-file-invoice-dollar', 'app_admin_myinvoicess')
                

            ];
        } else {
            return [

                yield MenuItem::section('operations_label', 'fa-solid fa-folder-open'),
                yield MenuItem::linkToRoute('operations_label', 'fa-solid fa-hand-sparkles', 'app_admin_operation'),
                yield MenuItem::linkToRoute('meetings_label', 'fas fa-calendar', 'app_admin_meeting'),
                yield MenuItem::linkToRoute('invoices_label', 'fas fa-file-invoice-dollar', 'app_admin_invoice'),

                yield MenuItem::section('my_interventions_label', 'fa-brands fa-redhat'),
                yield MenuItem::linkToRoute('my_operations_label', 'fa-solid fa-hand-sparkles', 'app_admin_myoperation'),
                yield MenuItem::linkToRoute('my_meetings_label', 'fas fa-calendar', 'app_admin_my_meetings'),
                yield MenuItem::linkToRoute('my_invoices_label', 'fas fa-file-invoice-dollar', 'app_admin_myinvoices'),
                

                yield MenuItem::section('users_label', 'fa-solid fa-users-line'),
                yield MenuItem::subMenu('users_label', 'fa-solid fa-users-rectangle')->setSubItems([
                    MenuItem::linkToCrud('customers_label', 'fa fa-arrow-right', Users::class)
                        ->setQueryParameter('job_title', 'Null'),
                    MenuItem::linkToCrud('employees_label', 'fa fa-arrow-right', Users::class)
                        ->setController(EmployeeCrudController::class)
                        ->setQueryParameter('job_title', 'Opérateur')
                ]),
                yield MenuItem::linkToCrud('addresses_label', 'fas fa-address-book', Address::class),

                yield MenuItem::section('my_profile_label', 'fa-solid fa-screwdriver-wrench'),
                yield MenuItem::linkToRoute('control_my_profile_label', 'fa fa-id-card', 'app_admin_profile'),
                yield MenuItem::subMenu('modify_my_profile_label', 'fas fa-bar')->setSubItems([
                    MenuItem::linkToRoute('password_label', 'fa fa-arrow-right', 'edit_admin_password'),
                    MenuItem::linkToRoute('contact_label', 'fa fa-arrow-right', 'edit_admin_profile')
                ]),
                yield MenuItem::section('my_history_label', 'fa-solid fa-clock-rotate-left'),
                yield MenuItem::linkToRoute('my_operations_label', 'fa-solid fa-hand-sparkles', 'app_admin_my_past_operation'),
                yield MenuItem::linkToRoute('my_meetings_label', 'fas fa-calendar', 'app_admin_my_meeting'), 
                yield MenuItem::linkToRoute('my_invoices_label', 'fas fa-file-invoice-dollar', 'app_admin_myinvoicess')
                

            ];
        }

    }
}
