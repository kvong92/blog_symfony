<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{

    private $postRepository;

    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    #[Route('/blog', name: 'app_blog')]
//    public function index(): Response
//    {
//        $posts = $this->postRepository->findAllPosts();
//        $this->listAction($posts, 10, 1);
//        return $this->render('blog/feed_post.html.twig', [
//            'posts' => $posts,
//        ]);
//    }

    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $posts = $this->postRepository->findAllPosts();

//        dd($posts);

        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );
//        dd($pagination);

        // parameters to template
        return $this->render('blog/feed_post.html.twig', ['pagination' => $pagination]);
    }

    #[Route('/blog/{id}', name: 'app_show_blog', methods: ['GET'])]
    public function show(Request $request, EntityManagerInterface $entityManager , int $id): Response
    {
        $post = $this->postRepository->GetAPost($id);

        if($post) {
            $this->redirect('app_blog');
        }

        //dd($post);

        return $this->render('blog/show.html.twig',[
            'post' => $post[0]
        ]);
    }


}
