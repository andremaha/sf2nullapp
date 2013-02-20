<?php

namespace SFScreenCasts\NullappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($role, $userName)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('NullBundle:Event');

        $event = $repo->findOneBy(array(
           'name' => 'Recording the First Episode'
        ));

        $content = $this->render('NullBundle:Default:index.html.twig', array('name' => $userName, 'event' => $event));

        return $content;
    }
}
