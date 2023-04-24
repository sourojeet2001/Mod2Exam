<?php
namespace App\Services;

/**
 * This class is used to fetch and return all the necessary details of books.
 */
class BooksData {

    /**
   * This function is used to load book details on ajax call.
   * 
   *  @param  array $books
   *    Gets the books array as parameter.
   * 
   *  @return array
   *    Returns an array by looping through the associative array.
   */
  function booksData(array $books) {
    foreach ($books as $book) {
      $booksArray[] = [
        'title' => $book->getTitle(),
        'author' => $book->getAuthor(),
        'cost' => $book->getCost(),
        'description' => $book->getDescription(),
        'imagePath' => $book->getImagePath(),
      ];
    }
    return $booksArray;
  }

}