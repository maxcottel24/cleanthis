<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\EditAdminProfileType;
use App\Form\EditAdminPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminProfileController extends AbstractController
{
    #[Route('/admin/profil', name: 'app_admin_profile')]
    public function index(): Response
    {
        return $this->render('admin/profile/index.html.twig', [
            'controller_name' => 'AdminProfileController',
        ]);
    }

    #[Route(path: '/admin/profil/edit', name: 'edit_admin_profile')]
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

    #[Route(path: '/admin/profil/mdp', name: 'edit_admin_password')]
    public function editPassword(Request $request, EntityManagerInterface $emi, UserPasswordHasherInterface $passwordHasher)
    {
        $user =$this->getUser();
        $form = $this->createForm(EditAdminPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $emi->persist($user);
            $emi->flush();

            $this->addFlash('success', 'Mot de passe mis à jour avec succès');
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/profile/edit_password.html.twig', [
            'editAdminPasswordType' => $form->createView()
        ]);
    }
}
