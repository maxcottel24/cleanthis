<?php

namespace App\Controller;

use App\Service\SendMailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, SendMailService $sendMailService): Response
    {
        // Créez un formulaire simple pour le contact
        $form = $this->createFormBuilder()
            ->add('firstname', TextType::class,  [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'form.label.firstname',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotBlank(),
                ]
            ])
            ->add('lastname', TextType::class,  [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'form.label.lastname',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotBlank(),
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Votre adresse email',
                'attr' => ['class' => 'form-control']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'attr' => ['class' => 'form-control']
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-primary mt-3']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            // Utilisez le service SendMailService pour envoyer l'email
            $sendMailService->send(
                $contactFormData['mail'],
                'acleanthis@gmail.com',
                'Nouveau message de contact de' .' '.$contactFormData['lastname'] . ' ' . $contactFormData['firstname'],
                'contact',
                [
                    'message' => $contactFormData['message'],
                    'mail' => $contactFormData['mail'],
                    'lastname' => $contactFormData['lastname'],
                    'firstname' => $contactFormData['firstname']
                ]
                // Pas de PDF attaché dans ce cas
            );

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('accesrapide/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
