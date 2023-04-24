<?php

namespace App\DataFixtures;

use App\Entity\Library;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      $bookList = [
        [
          'title' => '2 States',
          'imagePath' => './img/2states.jpg',
          'author' => 'Chetan Bhagat',
          'description' => 'Sample Text', 
          'cost' => 200,
        ],
        [
          'title' => 'The Boy with Broken',
          'genre' => 'Romantic',
          'imagePath' => './img/broken.jpg',
          'author' => 'Durjoy Dutta',
          'description' => 'Sample Text',
          'cost' => 250,
        ],
        [
          'title' => 'The Shadow',
          'genre' => 'Horror',
          'imagePath' => './img/ruskin.jpg',
          'author' => 'Ruskin Bond',
          'description' => 'Sample Text',
          'cost' => 300,
        ],
        [
          'title' => 'One Indian Girl',
          'genre' => 'Romantic',
          'imagePath' => './img/oneindian.jpg',
          'author' => 'Chetan Bhagat',
          'description' => 'Sample Text',
          'cost' => 150,
        ],
        [
          'title' => 'The Perfect Us',
          'genre' => 'Romantic',
          'imagePath' => './img/theperfectus.jpg',
          'author' => 'Durjoy Dutta',
          'description' => 'Sample Text',
          'cost' => 100,
        ],
        [
          'title' => 'It Starts with Us',
          'genre' => 'Romantic',
          'imagePath' => './img/starts.jpg',
          'author' => 'Collen Hoover',
          'description' => 'Sample Text',
          'cost' => 450
        ]
      ];
  
      foreach ($bookList as $bookData) {
        $book = new Library();
        $book->setTitle($bookData['title']);
        $book->setImagePath($bookData['imagePath']);;
        $book->setAuthor($bookData['author']);
        $book->setDescription($bookData['description']);
        $book->setCost($bookData['cost']);
        $manager->persist($book);
      }
        $manager->flush();
    }
}
