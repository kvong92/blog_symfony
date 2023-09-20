<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dd($this->tagRepository->findAllTags());

        $tags = $this->tagRepository->findAllTags();

        $builder
            ->add('title')
            ->add('summary')
            ->add('content')
            ->add('slug')
            ->add('imageFile')
            ->add('tags', ChoiceType::class, [
                'choices'=> $tags,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function (Tag $tag) {
                    return $tag->getName();
                },
                'choice_value' => function (Tag $tag) {
                    return $tag->getId();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
