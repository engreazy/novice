<?php
namespace Ijdb;
use Ninja\DatabaseTable;
use Ninja\Authentication;
class IjdbRoutes implements \Ninja\Routes
{
    private $authorsTable;
    private $jokesTable;
    private $categoriesTable;
    private $authentication;
    private $jokeCategoriesTable;

    public function __construct(){
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $jokesTableArgs = [$pdo,'joke','id','\Ijdb\Entity\Joke',[&$this->authorsTable,&$this->jokeCategoriesTable]];
        $authorsTableArgs = [$pdo,'author','id','\Ijdb\Entity\Author',[&$this->jokesTable]];
        $categoriesTableArgs = [$pdo,'category','id','\Ijdb\Entity\Category',[&$this->jokesTable,&$this->jokeCategoriesTable]];
        $this->jokesTable = new DatabaseTable(...$jokesTableArgs);
        $this->authorsTable = new DatabaseTable(...$authorsTableArgs);
        $this->categoriesTable = new DatabaseTable(...$categoriesTableArgs);
        $this->authentication = new Authentication($this->authorsTable, 'email', 'password');
        $this->jokeCategoriesTable = new DatabaseTable($pdo,'joke_category','categoryid');
    }
    public function getRoutes(): array{

    $jokeController = new \Ijdb\Controllers\Joke($this->jokesTable,$this->authorsTable,$this->categoriesTable, $this->authentication);
    $authorController = new \Ijdb\Controllers\Register($this->authorsTable);
    $loginController = new \Ijdb\Controllers\Login($this->authentication);
    $categoryController = new \Ijdb\Controllers\Category($this->categoriesTable);

    $routes = [
        'category/list' => [
            'GET' => [
                'controller' => $categoryController,
                'action' => 'list'
            ],
            'login' => true,
            'permissions' => \Ijdb\Entity\Author::LIST_CATEGORIES
        ],
        'category/delete' => [
            'POST' => [
                'controller' => $categoryController,
                'action' => 'delete'
            ],
            'login' => true,
            'permissions' => \Ijdb\Entity\Author::REMOVE_CATEGORIES
        ],
        'category/edit' => [
            'POST' => [
                'controller' => $categoryController,
                'action' => 'saveEdit'
            ],
            'GET' => [
                'controller' => $categoryController,
                'action' => 'edit'
            ],
            'login' => true,
            'permissions' => \Ijdb\Entity\Author::EDIT_CATEGORIES
        ],
        'author/permissions' =>[
            'GET' => [
                'controller' => $authorController,
                'action' => 'permissions'
            ],
            'POST' => [
                'controller' => $authorController,
                'action' => 'savePermissions'
            ],
            'login' => true,
            'permissions' => \Ijdb\Entity\Author::EDIT_USER_ACCESS
        ],
        'author/list' =>[
            'GET' => [
                'controller' => $authorController,
                'action' => 'list'
            ]
        ],
        'author/register' =>[
            'GET' => [
                'controller' => $authorController,
                'action' => 'registrationForm'
            ],
            'POST' => [
                'controller' => $authorController,
                'action' => 'registerUser'
            ]
        ],
        'author/success' =>[
            'GET' => [
                'controller' => $authorController,
                'action' => 'success'
            ]
        ],
        'joke/edit' => [
            'POST' => [
                'controller' => $jokeController,
                'action' => 'saveEdit'
            ],
            'GET'=>[
                'controller' => $jokeController,
                'action' => 'edit'
            ],
            'login' => true
        ],
        'joke/delete' =>[
            'POST' => [
                'controller' => $jokeController,
                'action' => 'delete'
            ],
            'login' => true
        ],
        'joke/list' => [
            'GET' => [
                'controller' => $jokeController,
                'action' => 'list'
            ]
        ],
        '' => [
            'GET' =>[
                'controller' => $jokeController,
                'action' => 'home'
            ]
        ],
        'login/error' =>[
            'GET' => [
                'controller' => $loginController,
                'action' => 'error'
            ]
        ],
        'login' => [
            'GET' => [
                'controller' => $loginController,
                'action' => 'loginForm'
            ],
            'POST' => [
                'controller' => $loginController,
                'action' => 'processLogin'
            ]
        ],
        'login/success' =>[
            'GET' => [
                'controller' => $loginController,
                'action' => 'success'
            ],
            'login' => true
        ],
        'logout' => [
            'GET' => [
                'controller' => $loginController,
                'action' => 'logout'
            ]
        ]
    ];
    return $routes;
  }

  public function getAuthentication(): \Ninja\Authentication {
    return $this->authentication;
  }
  public function checkPermission($permission):bool{
    $user = $this->authentication->getUser();
    if ($user && $user->hasPermission($permission)) {
      return true;
    }else{
      return false;
    }
  }
}