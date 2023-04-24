<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * It implements the functionality of login logout.
 */
class SecurityController extends AbstractController {
  
    #[Route(path: '/login', name: 'app_login')]    
    /**
     * This function is used to authenticate user based on the credentials provided
     * and sets up a session.
     * 
     *  @param  AuthenticationUtils $authenticationUtils
     *    Imports utilities from symfony security bundle.
     * 
     *  @return Response
     *    Authenticates user through symfony auth system. Renders back to the login page
     *    with error message if invalid credentials are provided.
     * 
     */
    public function login(AuthenticationUtils $authenticationUtils): Response {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]    
    /**
     * This functiom logs the user out by destroying the session using symfony auth system.
     * 
     *  @return void
     *    Throws an exception if any error occurs on logging out and unsetting the session.
     */
    public function logout(): void {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
