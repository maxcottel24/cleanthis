<?php

namespace App\Controller\Admin;

use App\Form\EditAdminProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProfileController extends AbstractController
{
    // #[Route('/admin/profile', name: 'app_admin_profile')]
    // public function index(): Response
    // {
    //     return $this->render('admin/profile/edit_profile.html.twig', [
    //         'controller_name' => 'AdminProfileController',
    //     ]);
    // }

    #[Route(path: '/admin/profile', name: 'edit_admin_profile')]
    public function editProfile(Request $request, EntityManagerInterface $emi)
    {
        $user =$this->getUser();
        $form = $this->createForm(EditAdminProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emi->persist($user);
            $emi->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès');
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/profile/edit_profile.html.twig', [
            'editAdminProfileType' => $form->createView()
        ]);
    }
}
