<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFullname('john doe');
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_USER']);
        $user->setShowFullname(0);
        $user->setFullname('testname');
        $user->setPassword('1234');
        $manager->persist($user);

        $post = new Post();
        $post->setAuthor($user);
        $post->setTitle('My first post');
        $post->setSummary('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $post->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
        $post->setPublishedAt(new \DateTime());
        $post->setSlug('my-first-post');
        $post->setImageFile('my-first-post.jpg');

        $manager->persist($post);
        $manager->flush($post);
    }
}
