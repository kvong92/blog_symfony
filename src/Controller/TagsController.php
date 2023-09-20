<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/tags')]
class TagsController extends AbstractController
{
    #[Route('/list', name: 'app_tags_list', methods: ['GET'])]
    public function index(TagRepository $tagRepository): Response
    {
        dump($tagRepository->findAll());


        return $this->render('tags/list.html.twig', [
            'tag' => $tagRepository->findAll()
        ]);
    }

    #[Route('/edit/{id}', name: 'app_tags_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_tags_list');
        }

        return $this->render('tags/edit.html.twig', [
            'tag' => $tag,
            'form' => $form->createView()
        ]);

    }

    #[Route('/delete/{id}', name: 'app_tags_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Tag $tag, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($tag);
        $entityManager->flush();
        return $this->redirectToRoute('app_tags_list');
    }

    #[Route('/new', 'app_tags_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($tag);
            $entityManager->flush();
        }

        return $this->render('tags/new.html.twig', [
            'tag'=>$tag,
            'form' => $form->createView()
        ]);

    }

    private function getDoctrine()
    {
    }
}




