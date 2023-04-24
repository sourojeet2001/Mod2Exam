<?php

namespace App\Controller;

use App\Entity\Uploads;
use App\Repository\LibraryRepository;
use App\Repository\UploadsRepository;
use App\Services\BooksData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Exception as DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Maincontroller Initializes entity objects and handles all the routing and 
 * returns responses on all ajax calls.
 */
class MainController extends AbstractController {

  /**
   * Initializing KERNALUPLOADIMAGE constant for storing image path.
   */
  const KERNALUPLOADIMAGE = '/public/uploaded_image/';

  /**
   * Initializing UPLOADIMAGE constant for storing upload image.
   */
  const UPLOADIMAGE = '/uploaded_image/';

  /**
   *  @var LibraryRepository $booksRepository
   *    To initialize object of Library Repository.
   */
  private $booksRepository;

  /**
   *  @var EntityManagerInterface $em
   *    To initialize object of EntityManagerInterface.
   */
  private $em;

  /**
   *  @var Uploads $uploads
   *    To initialize object of Uploads Entity.
   */
  private $uploads;

  /**
   *  @var Uploads $uploadsRepository
   *    To initialize object of Uploads Repository.
   */
  private $uploadsRepository;

  /**
   *  @var BooksData $booksData
   *    To initialize object of BooksData Service.
   */
  private $booksData;
  
  /**
   * Constructor initializes object of different entites and interfaces.
   *
   *  @param  object $booksRepository
   *    Initializes object of Library Repository.
   *  @param  object $em
   *    Initializes object of EntityManagerInterface.
   */
  public function __construct(LibraryRepository $booksRepository, UploadsRepository $uploadsRepository, EntityManagerInterface $em) {
    $this->uploadsRepository = $uploadsRepository;
    $this->booksRepository = $booksRepository;
    $this->booksData = new BooksData();
    $this->uploads = new Uploads();
    $this->em = $em;
  }


  #[Route('/home', name: 'home')]  
  /**
   * This function redirects to the home page with all book listings.
   *
   *   @return Response
   *    Renders back with landing page.
   */
  public function home(): Response {
    $books = $this->booksRepository->findAll();
    $uploads = $this->uploadsRepository->findAll();
    return $this->render('main/home.html.twig', 
    ['books' => $books,
      'uploads' => $uploads
    ]);
  }


  #[Route('/sort', name: 'sort')]  
  /**
   * This function is used to sort the books according to price and author name.
   *
   *  @param  Request $request
   *    To initialize object of HttpRequest
   * 
   *  @return JsonResponse
   *    Returns a response by fetching data in a sorted order from Database.
   */
  public function sort(Request $request): JsonResponse {
    $item = $request->get('item');
    if ($item) {
      if ($item == 'costs') {
        $books = $this->booksRepository->findBy([], ['cost' => 'ASC']);
      } 
      elseif ($item == 'authors') {
        $books = $this->booksRepository->findBy([], ['author' => 'ASC']);
      } 
      return new JsonResponse([
        'response' => TRUE,
        'data' => $this->booksData->booksData($books),
      ]);
    }
    return new JsonResponse([
      'response' => FALSE,
      'message' => 'Invalid request'
    ]);
  }

  #[Route('/bookupload', name: 'uploads')]
  /**
   * This function uploads a book to the Database and local directory.
   * 
   *  @param  Request $request
   *    Accepts an upload request from user.
   * 
   *  @return Response
   *    On successful file upload to the Database redirects to landing page.
   */
  public function uploads(Request $request): Response {
    // Getting response from form submission.
    $thumbnail = $request->files->get('imagePath');
    $title = $request->get('title');
    $description = $request->get('description');
    $cost = $request->get('cost');
    $author = $request->get('author');
    // Giving unique names to the uploaded files to avoid conflict in same file names.
    $newThumbName = uniqid() . "." . $thumbnail->guessExtension();
    // Storing files to local directory.
    try {
      $thumbnail->move($this->getParameter('kernel.project_dir') . MainController::KERNALUPLOADIMAGE, $newThumbName);
    } 
    catch (FileException $e) {
      return new Response($e->getMessage());
    }
    
    try {
    $adminUpload = $this->uploads;
    // Populating the database based on the uploaded data through form submission.
    $adminUpload->setImagePath(MainController::UPLOADIMAGE . $newThumbName);
    $adminUpload->setAuthor($author);
    $adminUpload->setTitle($title);
    $adminUpload->setDescription($description);
    $adminUpload->setCost($cost);
    $this->em->persist($adminUpload);
    $this->em->flush();
      return new JsonResponse(['uploadResponse' => TRUE]);
    }
    catch (DBALException $e) {
      return new Response($e->getMessage());
    }
  }

  #[Route('/search', name: 'search')]  
  /**
   * This function is used to search books according to their title.
   *
   *  @param  Request $request
   *    To initialize object of HttpRequest
   * 
   *  @return JsonResponse
   *    Returns a response by fetching data whose title matches with user input.
   */
  public function search(Request $request): JsonResponse {
    $item = $request->get('search');
    // Fetching resukts which matches with the search parameter.
    $books = $this->booksRepository->findBy(['title' => $item]);

    if ($books) {
      return new JsonResponse([
        'response' => TRUE,
        'data' => $this->booksData->booksData($books),
      ]);
    }
    return new JsonResponse([
      'response' => FALSE,
      'message' => 'Invalid request'
    ]);
  }

}