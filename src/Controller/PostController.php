<?php

namespace App\Controller;
use App\Entity\Post;
use App\Form\PostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    public function new(Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $post = new Post();
        //$post->setAuthor($this->getUser());

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        #print($user->getId());
        //dd($user);
        //die(':)');

        $form = $this ->createForm(PostFormType::class, $post);

        return $this->render('post/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
