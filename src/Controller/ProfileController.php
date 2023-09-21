<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChangePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
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
    #[Route('/profile_change_pass', name: 'app_profile', locale: 'en')]
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

    }
}
