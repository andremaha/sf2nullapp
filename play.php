<?php

use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);


$loader = require_once __DIR__.'/app/bootstrap.php.cache';
require_once __DIR__.'/app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$kernel->boot();

$container = $kernel->getContainer();
$container->enterScope('request');
$container->set('request', $request);

// all our setup is done!

// Let's play with doctrine entity!

use SFScreenCasts\NullappBundle\Entity\Event;

$event = new Event();
$event->setName('Recording the First Episode');
$event->setLocation('Home');
$event->setTime(new \DateTime('tomorrow noon'));
$event->setDetails('This will be awesome - I will record first episode for free and then will start selling them');

$em = $container->get('doctrine')->getManager();
$em->persist($event);
$em->flush();