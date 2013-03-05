<?php

namespace SFScreenCasts\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
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

                // Authenticate the User
                $this->authenticateUser($user);

                // Give the user feedback that her registration was successful
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Registration is complete!');

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

    /**
     * Authenticate new registered user after the registration process went successfully
     *
     */
    private function authenticateUser(UserInterface $user)
    {
        // The firewall name
        $providerKey = 'secured_area';

        // Create an authentication package called 'token'
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

        // Pass the package to the Symfony's security system
        $this->container->get('security.context')->setToken($token);
    }

}