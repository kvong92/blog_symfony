<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class PostFormType extends AbstractType
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tags = $this->tagRepository->findAllTags();

        //dd($tags);

//        $choices = [];
//
//        foreach($tags as $tag) {
//            $choices[$tag->getName()] = function ($tag) {
//                $newtag = new Tag();
//                $newtag->setName($tag);
//                return $newtag;
//            };
//        }

        //dd($choices);

        $builder
            ->add('title')
            ->add('summary')
            ->add('content')
            ->add('slug')
            ->add('imageFile', FileType::class, [
                'required' => false,
                'mapped' => true,
                'label' => 'Image (JPG or PNG file)',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG or PNG image',
                    ])
                ],
            ]);
            //->add('tags');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
