<?php

    namespace AppBundle\DataFixtures;

    use AppBundle\Entity\User;
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Common\Persistence\ObjectManager;

    class UserFixtures extends Fixture
    {
        public function load(ObjectManager $manager)
        {

            $user1 = new User();
            $user1->setFirstName('Amandine');
            $user1->setLastName('Dargon');
            $user1->setEmail('amandine@amandine.fr');
            $user1->setPicture('https://fortunedotcom.files.wordpress.com/2017/10/lego-nasa-hamilton.jpg');
            $user1->setScore('10');
            $user1->setVoted('1');
            $manager->persist($user1);

            $user2 = new User();
            $user2->setFirstName('Carla');
            $user2->setLastName('Del Moral');
            $user2->setEmail('carla@carla.fr');
            $user2->setPicture('https://www.heyuguys.com/images/2014/03/Black-Widow1.jpg');
            $user2->setScore('11');
            $user2->setVoted('1');
            $manager->persist($user2);

            $user3 = new User();
            $user3->setFirstName('Gwendoline');
            $user3->setLastName('Belnard');
            $user3->setEmail('gwendoline@gwendoline.fr');
            $user3->setPicture('https://vignette.wikia.nocookie.net/lego/images/f/fa/Maria_Hill.png/revision/latest?cb=20160206153143');
            $user3->setScore('12');
            $user3->setVoted('1');
            $manager->persist($user3);

            $user4 = new User();
            $user4->setFirstName('Anne-Claire');
            $user4->setLastName('Petit');
            $user4->setEmail('anneclaire@anneclaire.fr');
            $user4->setPicture('https://vignette.wikia.nocookie.net/lego/images/0/0e/Scarlet_witch.png/revision/latest?cb=20151219184812');
            $user4->setScore('13');
            $user4->setVoted('1');
            $manager->persist($user4);

            $manager->flush();
        }
    }