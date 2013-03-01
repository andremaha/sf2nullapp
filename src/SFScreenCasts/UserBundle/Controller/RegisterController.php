<?php

namespace SFScreenCasts\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFScreenCasts\UserBundle\Form\RegisterFormType;
use SFScreenCasts\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{

    /**
     * @Route("/register", name="user_register")
     * @Template
     */
    public function registerAction(Request $request)
    {

        $defaultUser = new User();
        $defaultUser->setUsername('username');
        $defaultUser->setEmail('username@example.com');

        $form = $this->createForm(new RegisterFormType());

        if ($request->isMethod('POST')) {

            $form->bind($request);

            if ($form->isValid()) {

                $user = $form->getData();

                $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();

                $url = $this->generateUrl('event');

                return $this->redirect($url);

            }



        }

        return array('form' => $form->createView());
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user);

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

}