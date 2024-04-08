<?php

namespace App\Controller;

use Exception;
use App\Service\SendMailService;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, SendMailService $sendMailService, TranslatorInterface $translator): Response
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
                'label' => 'form.label.email',
                'attr' => ['class' => 'form-control']
            ])
            ->add('message', TextareaType::class, [
                'label' => 'form.label.message',
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
                'Nouveau message de contact de' . ' ' . $contactFormData['lastname'] . ' ' . $contactFormData['firstname'],
                'contact',
                [
                    'message' => $contactFormData['message'],
                    'mail' => $contactFormData['mail'],
                    'lastname' => $contactFormData['lastname'],
                    'firstname' => $contactFormData['firstname']
                ]
                // Pas de PDF attaché dans ce cas
            );

            $message = $translator->trans('Votre message a été envoyé avec succès.');
            $this->addFlash('success', $message);

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('accesrapide/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recruitment', name: 'app_recruitment')]
    public function recrutement(Request $request, SendMailService $sendMailService, TranslatorInterface $translator): Response
    {
        $form = $this->createFormBuilder()
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'form.label.firstname',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotBlank(),
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'form.label.lastname',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotBlank(),
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => 'form.label.email',
                'attr' => ['class' => 'form-control']
            ])
            ->add('cv', FileType::class, [
                'label' => 'form.label.CV.request',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => ['application/pdf'],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF valide',
                    ])
                ],
            ])
            ->add('lettre_motivation', FileType::class, [
                'label' => 'form.label.motiv.request',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => ['application/pdf'],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF valide',
                    ])
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'form.label.message',
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

            try {
                // Gérez le téléchargement du CV
                $cvFile = $form->get('cv')->getData();
                $cvPath = null;
                if ($cvFile) {
                    $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename . '-' . uniqid() . '.' . $cvFile->guessExtension();

                    // Déplacez le fichier dans le répertoire où les CV sont stockés
                    $cvFile->move(
                        $this->getParameter('cv_directory'),
                        $newFilename
                    );

                    $cvPath = $this->getParameter('cv_directory') . '/' . $newFilename;
                }

                // Gérez le téléchargement de la lettre de motivation
                $motivationLetterFile = $form->get('lettre_motivation')->getData();
                $letterPath = null;
                if ($motivationLetterFile) {
                    $originalFilename = pathinfo($motivationLetterFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename . '-' . uniqid() . '.' . $motivationLetterFile->guessExtension();

                    // Déplacez le fichier dans le répertoire spécifié
                    $motivationLetterFile->move(
                        $this->getParameter('letters_directory'),
                        $newFilename
                    );

                    $letterPath = $this->getParameter('letters_directory') . '/' . $newFilename;
                }

                $sendMailService->sendRecruitment(
                    $contactFormData['mail'],
                    'acleanthis@gmail.com',
                    'Nouvelle candidature de ' . $contactFormData['lastname'] . ' ' . $contactFormData['firstname'],
                    'recrutement_template',
                    [
                        'message' => $contactFormData['message'],
                        'mail' => $contactFormData['mail'],
                        'lastname' => $contactFormData['lastname'],
                        'firstname' => $contactFormData['firstname'],
                    ],
                    $cvPath,
                    $letterPath
                );

                $message = $translator->trans('Votre candidature a été envoyée avec succès.');
                $this->addFlash('success', $message);
            } catch (Exception $e) {
                $message = $translator->trans('Une erreur est survenue lors de cet envoi de candidature : ');
                $this->addFlash('error', $message . $e->getMessage());
            }

            return $this->redirectToRoute('app_recruitment');
        }

        return $this->render('accesrapide/recruitment.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
