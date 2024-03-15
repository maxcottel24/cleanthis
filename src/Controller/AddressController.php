<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Address;
use App\Entity\Meeting;
use App\Form\Address1Type;
use App\Form\Address1TypeEdit;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/address')]
class AddressController extends AbstractController

{

    #[Route('/{id}', name: 'app_address_index', methods: ['GET'])]
    public function index (int $id ,AddressRepository $addressRepository , Security $security ): Response
    {
        $user = $security->getUser();

        if ($user->getId() == $id ) {

        $addresses = $addressRepository->findBy(['user' => $id]);

        return $this->render('address/index.html.twig', [
         'addresses' => $addresses,
        ]);
    } else {
        return $this->redirectToRoute('app_home'); }
    }



    #[Route('/{id}/inscription', name: 'app_address_inscription', methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();

        $existingPrimaryAddress = $entityManager->getRepository(Address::class)->findOneBy([
            'user' => $user->getId(),
            'is_primary' => true,
        ]);
        
        if ($existingPrimaryAddress !== null) {
            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }
        // if ($user instanceof Users) {
            $address = new Address();
            $form = $this->createForm(Address1Type::class, $address);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {
                $address->setUser($user);

                $address->setisPrimary(true);

                $entityManager->persist($address);
                $entityManager->flush();

                return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
            }
        // }

        return $this->render('address/inscription.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_address_show', methods: ['GET'])]
    public function show(Address $address): Response
    {
        return $this->render('address/show.html.twig', [
            'address' => $address,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_address_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Address $address, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();

        if ($user->getId() !== $address->getUser()->getId()) {
            $this->addFlash('error', 'Vous n’êtes pas autorisé à modifier cette adresse.');
            return $this->redirectToRoute('app_address_index', ['id' => $user->getId()]);
        }
        $meetingCount = $entityManager->getRepository(Meeting::class)->count(['address' => $address]);

    if ($meetingCount > 0) {
        $this->addFlash('warning', 'Cette adresse est actuellement utilisée par un ou plusieurs RDV et ne peut pas être modifiée.');
        return $this->redirectToRoute('app_address_index', ['id' => $user->getId()]);
    }
    
        $originalIsPrimary = $address->isIsPrimary();
        $form = $this->createForm(Address1TypeEdit::class, $address);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($originalIsPrimary && !$address->isIsPrimary()) {
                $primaryAddressCount = $entityManager->getRepository(Address::class)->count([
                    'user' => $user,
                    'is_primary' => true,
                ]);
    
                if ($primaryAddressCount <= 1) {
                    $this->addFlash('error', 'Vous devez avoir au moins une adresse principale.');
                    return $this->redirectToRoute('app_address_edit', ['id' => $address->getId()]);
                }
            }
    
            if ($address->isIsPrimary()) {
                $previousPrimary = $entityManager->getRepository(Address::class)->findOneBy([
                    'user' => $user,
                    'is_primary' => true,
                ]);
    
                if ($previousPrimary && $previousPrimary !== $address) {
                    $previousPrimary->setIsPrimary(false);
                    $entityManager->persist($previousPrimary);
                }
            }
    
            $entityManager->flush();
            $this->addFlash('success', 'Adresse mise à jour avec succès.');
            return $this->redirectToRoute('app_address_index', ['id' => $user->getId()]);
        }
    
        return $this->render('address/edit.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_address_delete', methods: ['GET','POST'])]
public function delete(Request $request, Address $address, EntityManagerInterface $entityManager, Security $security): Response
{
    $user = $security->getUser();

    if ($user->getId() === $address->getUser()->getId()) {
        if ($address->isIsPrimary()) {
            $this->addFlash('error', 'Impossible de supprimer une adresse principale.');
        } else {
            $meetingCount = $entityManager->getRepository(Meeting::class)->count(['address' => $address]);
            if ($meetingCount > 0) {
                $this->addFlash('error', 'Cette adresse est associée à un ou plusieurs RDV et ne peut pas être supprimée.');
            } else if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
                $entityManager->remove($address);
                $entityManager->flush();
                $this->addFlash('success', 'Adresse supprimée avec succès.');
            } else {
                $this->addFlash('error', 'Token de sécurité invalide.');
            }
        }
    } else {
        $this->addFlash('error', 'Vous n’êtes pas autorisé à supprimer cette adresse.');
    }

    return $this->redirectToRoute('app_address_index', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
}
#[Route('/{id}/secondary', name: 'app_address_secondary', methods: ['GET', 'POST'])]
public function newSecondary(Request $request, EntityManagerInterface $entityManager, Security $security): Response
{
    $user = $security->getUser();

    if ($user instanceof Users && $user->getAddressesCount() < 4) {
        $address = new Address();
        $form = $this->createForm(Address1Type::class, $address);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($user);
            $address->setIsPrimary(false);
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('app_address_index', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('address/secondary.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    } else {
       
        $this->addFlash('warning', 'Il est impossible de voir plus de 4 adresses...');
        return $this->redirectToRoute('app_address_index', ['id' => $user->getId()]);
    }
}

    }











