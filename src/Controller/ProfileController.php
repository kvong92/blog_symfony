<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChangePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class ProfileController extends AbstractController
{

    private $doctrine;

    // Injectez le service Doctrine dans le constructeur du contrôleur
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/profile/change-password", name="profile_change_password")
     */
    /*#[Route('/profile_change_pass', name: 'app_profile', locale: 'en')]
    public function changePassword(Request $request): Response
    {
        $user = $this->getUser();


        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Vérifiez si le mot de passe actuel est correct
            if (password_verify($data['currentPassword'], $user->getPassword())) {
                if ($data['newPassword'===$data['newPassword2']]) {
                    // Encodez et mettez à jour le nouveau mot de passe
                    $newPassword = password_hash($data['newPassword'], PASSWORD_DEFAULT);
                    $user->setPassword($newPassword);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->flush();

                    $this->addFlash('success', 'Votre mot de passe a été changé avec succès.');
                    return $this->redirectToRoute('app_homepage');
                }
            } else {
                $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
            }
        }

        return $this->render('profile/change_password.html.twig', [
            'form' => $form->createView(),
        ]);

    }*/

    #[Route('/profile_change_pass', name: 'app_profile', locale: 'en')]
    public function updatePassword(Request $request, TokenStorageInterface $tokenStorage)
    {
        $form = $this->createForm(ChangePasswordFormType::class);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire
            $formData = $form->getData();

            // Vérification du mot de passe actuel
            $user = $this->getUser();

            //$userActuel = $tokenStorage->getToken()->getUser();
            //$userId = $userActuel->getId();
            /*if (!password_verify($formData['current_password'], $user->getPassword())) {
                // Mot de passe incorrect, afficher une erreur
                $this->addFlash('error', 'Mot de passe incorrect.');
                return $this->redirectToRoute('app_profile');
            }*/


            // Mise à jour du mot de passe
            $newPassword = password_hash($formData['newPassword'], PASSWORD_DEFAULT);
            $user->setPassword($newPassword);

            // Enregistrement des modifications
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // Affichage d'un message de succès
            $this->addFlash('success', 'Password modifié avec succès.');
            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('profile/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $form = $this->createFormBuilder($user)
            ->add('fullname', TextType::class, ['label' => 'edit fullname :' ])
            ->add('email', TextType::class, ['label' => 'edit email :'])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('profile');
        }



        return $this->render('profile/profile.html.twig', ['controller_name' => 'ProfileController','form' => $form->createView()]);
    }
}

