<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

    /**
     * 
     * @todo use real provider
     */
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('AppBundle:Common:login.html.twig', array('error' => $error));
    }

}
