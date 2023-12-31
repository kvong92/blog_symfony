<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Mapping\Annotation as Vich; // Use Vich annotations for file uploads
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Post')
            ->setEntityLabelInPlural('Posts list')
            ->setSearchFields(['author', 'text', 'email'])
            ->setDefaultSort(['publishedAt' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Post Details'),
            TextField::new('title'),
            TextareaField::new('summary'),
            TextareaField::new('content'),
            DateTimeField::new('publishedAt'),
            SlugField::new('slug') // Add SlugField for generating slugs
            ->setTargetFieldName('title') // Specify the field to use for slug generation
            ->hideOnIndex(), // Opti
//            TextField::new('slug'),

            FormField::addPanel('Additional Details'),
            AssociationField::new('tags')
                ->setFormTypeOptions([
                    'by_reference' => false, // To ensure changes are tracked correctly
                ])
                ->autocomplete()
                ->setSortable(true)
                ->setHelp('Select tags for the post')
                ->onlyOnForms(),

            FormField::addPanel('Image Details'),
            ImageField::new('imageFile')
                ->setBasePath('/media/images') // Update to your desired base path
                ->setUploadDir('public/media/images') // Use the correct directory path
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[uuid].[extension]')
                ->onlyOnForms()
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $user = $this->getUser(); // Get the currently authenticated user

        if ($user) {
            $post = new Post();
            $post->setAuthor($user);
            $post->setPublishedAt(new \DateTime());
            $post->setSlug('');
            $post->setImageFile('');
            $post->setSummary('');
            $post->setContent('');
            $post->setTitle('');
            return $post;
        }

        return parent::createEntity($entityFqcn);
    }

    public function persistEntity(EntityManagerInterface|\Doctrine\ORM\EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Post) {
            parent::persistEntity($entityManager, $entityInstance);

            // Add a flash message after successfully creating the entity
            $this->addFlash('success', 'Post created successfully.');

            // You can customize the message type ('success', 'info', 'warning', 'error') and content
        } else {
            // Handle the case where $entityInstance is not an instance of Post
            parent::persistEntity($entityManager, $entityInstance);
        }
    }
}
