<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * RegistrationController handles everything related to user registration process.
 * Encodes passwords and store onto the database.
 */
class RegistrationController extends AbstractController {

  /**
   *  @var UserPasswordHasherInterface $userPasswordHasher
   *    Initialise object of UserPasswordHasherInterface.
   */
  private $userPasswordHasher;

  /**
   *  @var EntityManagerInterface $entityManager
   *    Initialise object of EntityManagerInterface.
   */
  private $entityManager;

  /**
   *  @var User $user
   *    Initialise object of User entity..
   */
  private $user;

    /**
   * Constructor Initializes objects of different entities and interfaces.
   * 
   *  @param  UserPasswordHasherInterface $userPasswordHasher
   *    Initializing userPasswordHasher object by importing UserPasswordHasherInterface
   *    of symfony.
   *  @param  EntityManagerInterface $entityManager
   *    Initializing entityManager object by importing EntityManagerInterface of symfony.
   */
  public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) {
    $this->userPasswordHasher = $userPasswordHasher;
    $this->entityManager = $entityManager;
    $this->user = new User();
  }

    #[Route('/register', name: 'app_register')]    
    /**
     * This function is used for user registration and sending a welcome mail to 
     * regsitered users.
     * 
     *  @param Request $request
     *    Initializing object of HttpRequest.
     * 
     *  @return Response
     *    Redirects back to songs route on successful registration else throw back to 
     *    registration page.
     */
    public function register(Request $request): Response {
        $form = $this->createForm(RegistrationFormType::class, $this->user);
        $form->handleRequest($request);
        // Handling form submission request.
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $this->user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $this->user,
                    $form->get('plainPassword')->getData()
                )
            );
            $this->entityManager->persist($this->user);
            $this->entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
