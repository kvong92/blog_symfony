<?php

namespace App\Controller;
use App\Entity\Post;
use App\Entity\Tag;
use App\Form\PostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostController extends AbstractController
{
    #[Route('/newpost', 'new_post')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
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

            //$form->getData();
            if ($form->isSubmitted() && $form->isValid()) {

            }
                /** @var UploadedFile $brochureFile */
                $brochureFile = $form->get('imageFile')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $post->setImageFile($newFilename);
                }

            $entityManager->persist($post);
            $entityManager->persist($tag);
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }


        return $this->render('post/index.html.twig', ['form' => $form->createView()]);
    }
}
