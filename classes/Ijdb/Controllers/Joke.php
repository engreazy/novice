<?php
namespace Ijdb\Controllers;
use Ninja\DatabaseTable;
use \Ninja\Authentication;
class Joke{
  private $authorsTable;
  private $jokesTable;
  private $categoriesTable;
  private $authentication;


  public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable,DatabaseTable $categoriesTable, Authentication $authentication){
    $this->jokesTable = $jokesTable;
    $this->authorsTable = $authorsTable;
    $this->categoriesTable = $categoriesTable;
    $this->authentication = $authentication;
  }

  public function list(){
    if (isset($_GET['category'])) {
      $category = $this->categoriesTable->findById($_GET['category']);
      $jokes = $category->getJokes();
    }else{
      $jokes = $this->jokesTable->findAll(); #returns collection/array of joke Entity object from the Joke Entity /DatabaseTable class
    }
    $title = 'Joke list';
    $totalJokes = $this->jokesTable->total();
    $author = $this->authentication->getUser();

    return [
      'template' => 'jokes.html.php',
      'title' => $title,
      'variables' => [
        'totalJokes' => $totalJokes,
        'jokes' => $jokes,
        'user' => $author,
        'categories' => $this->categoriesTable->findAll()
      ]
    ];
  }

  public function home(){
    $title = 'Internet Joke Database';

    return ['template' => 'home.html.php', 'title' => $title];
  }

  public function delete(){
    $author = $this->authentication->getUser();
    $joke = $this->jokesTable->findById($_POST['id']);
    if ($joke->authorid != $author->id && !$author->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)) {
      return;
    }
    $this->jokesTable->delete($_POST['id']);
    header('location:/novice/joke/list');
  }
  public function saveEdit(){

    $authorObject = $this->authentication->getUser();

    $joke = $_POST['joke'];
    $joke['jokedate'] = new \DateTime();

    if (isset($_GET['id'])) {
      $jokeObject = $this->jokesTable->findById($_GET['id']);
      if ($jokeObject->authorid != $authorObject->id) {
        return "could not be deleted";
      }
    }

    $jokeEntity = $authorObject->addJoke($joke);// save to DB and returns a Joke Entity object
    #return $jokeEntity;
    $jokeEntity->clearCategories(); // remove all categories
    foreach($_POST['category'] as $categoryid){
      $jokeEntity->addCategory($categoryid); // assign a joke to a category
    }

    // $this->jokesTable->save($joke);
    header('location:/novice/joke/list');
  }
  public function edit(){
    $author = $this->authentication->getUser();
    $categories = $this->categoriesTable->findAll();
      if (isset($_GET['id'])) {
        $joke = $this->jokesTable->findById($_GET['id']);
      }

      $title = 'Edit Joke';
      return [
        'template' => 'editjoke.html.php',
        'title' => $title,
        'variables' => [
          'joke' => $joke ?? null,
          'user' => $author,
          'categories' => $categories
        ]
      ];
  }
}