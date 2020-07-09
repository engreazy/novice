<?php
namespace Ijdb\Controllers;
use \Ninja\DatabaseTable;

class Register
{
  private $authorsTable;
  public function __construct(DatabaseTable $authorsTable){
    $this->authorsTable = $authorsTable;
  }

  public function registrationForm()
  {
    return ['template'=>'register.html.php','title'=> 'Register an account'];
  }

  public function success(){
    return ['template' => 'registersuccess.html.php','title' => 'Registration Successful'];
  }

  public function registerUser(){
    $author = $_POST['author'];
    //assume the data is valid to begin with
    $valid  = true;
    $errors = [];

    //set $valid to false
    if (empty($author['name'])) {
      $valid = false;
      $errors[] = 'Name cannot be blank';
    }
    if (empty($author['email'])) {
      $valid = false;
      $errors[] = 'email cannot be blank';
    }else if(filter_var($author['email'],FILTER_VALIDATE_EMAIL) == false){
      $valid = false;
      $errors[] = 'Invalid email address';
    }else{
      //if the email is not blank and valid:
      //convert the email to lowercase
      $author['email'] = strtolower($author['email']);
      //search for the lowercase version of the author['email']
      if (count($this->authorsTable->find('email',$author['email'])) > 0) {
        $valid  = false;
        $errors[] = 'That email address is already registered';
      }
    }
    if(empty($author['password'])){
      $valid = false;
      $errors[] = 'password cannot be blank';
    }

    //if $valid is still true, no fields were blank
    // and the data can be added
    if($valid == true){
      //hash the password before saving it in the database
      $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
      $this->authorsTable->save($author);
      header('location:/novice/author/success');
    }else{
      //if the data is not valid, show the form again
      return ['template' => 'register.html.php', 'title' => 'Register an account',
      'variables' => [
        'errors' => $errors,
        'author' => $author
      ]];
    }

  }

  public function list(){
    $authors = $this->authorsTable->findAll();
    return ['template' => 'authorlist.html.php','title' => 'Author List',
    'variables' => [
      'authors' => $authors
    ]];
  }

  public function permissions(){
    $author = $this->authorsTable->findById($_GET['id']);
    $reflected = new \ReflectionClass('\Ijdb\Entity\Author');//I don't have access to Entity Author class thus the need for Reflection class
    $constants = $reflected->getConstants();
    return['template' => 'permissions.html.php','title' => 'Edit Permissions','variables' => [
      'author' => $author,
      'permissions' => $constants
    ]];
  }

  public function savePermissions(){
    $author=[
      'id' => $_GET['id'],
      'permissions' => array_sum($_POST['permissions'] ?? [])
    ];
    $this->authorsTable->save($author);
    header('location: /novice/author/list');
  }
}