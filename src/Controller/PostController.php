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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $post = new Post();

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        $user = $this->getUser();
        $post->setAuthor($user);

        $time = new \DateTime();
        $time->format('H:i:s \O\n Y-m-d');
        $post->setPublishedAt($time);

        $tag = new Tag();
        $tag->setName('test');
        $post->addTag($tag);


        if($form->isSubmitted() && $form->isValid()){
            //dd($post);
            $entityManager->persist($post);
            $entityManager->persist($tag);
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }


        return $this->render('post/index.html.twig', ['form' => $form->createView()]);
    }
}
