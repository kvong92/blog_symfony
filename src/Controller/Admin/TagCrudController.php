<?php
// src/Controller/Admin/TagCrudController.php

namespace App\Controller\Admin;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Tag) {
            parent::persistEntity($entityManager, $entityInstance);

            // Add a flash message after successfully creating the entity
            $this->addFlash('success', 'Tag created successfully.');

            // You can customize the message type ('success', 'info', 'warning', 'error') and content
        } else {
            // Handle the case where $entityInstance is not an instance of Tag
            parent::persistEntity($entityManager, $entityInstance);
        }
    }
}
