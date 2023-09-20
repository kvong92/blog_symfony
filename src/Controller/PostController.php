<?php

namespace App\Controller;
use App\Entity\Post;
use App\Entity\Tag;
use App\Form\PostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/newpost', 'new_post')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();
            $post->setAuthor($user);

            if($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($post);
                $entityManager->flush();
                return $this->redirectToRoute('app_homepage');
            }
        }

        return $this->render('post/index.html.twig', ['form' => $form->createView()]);
    }
}
