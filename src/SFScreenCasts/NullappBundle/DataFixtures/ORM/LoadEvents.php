<?php

namespace SFScreenCasts\NullappBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SFScreenCasts\NullappBundle\Entity\Event;

class LoadEvents implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event1->setName('Recording the First Episode');
        $event1->setLocation('Home');
        $event1->setTime(new \DateTime('tomorrow noon'));
        $event1->setDetails('This will be awesome - I will record first episode for free and then will start selling them');
        $manager->persist($event1);


        $event2 = new Event();
        $event2->setName('Recording the Second Episode');
        $event2->setLocation('Home');
        $event2->setTime(new \DateTime('tomorrow noon'));
        $event2->setDetails('This will be awesome - I will record second episode for free and then will start selling them');
        $manager->persist($event2);

        $manager->flush();
    }
}