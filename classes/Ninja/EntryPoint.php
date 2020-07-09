<?php
namespace Ninja;
class EntryPoint
{
  private $route;
  private $method;
  private $routes;

  public function __construct(string $route,string $method,\Ninja\Routes $routes){
    $this->route = $route;
    $this->method = $method;
    $this->routes = $routes;
    $this->checkUrl();
  }

  private function checkUrl(){
    if ($this->route !== strtolower($this->route)){
      http_response_code(301);
      header('location:/novice/'.strtolower($this->route));
    }
  }

  private function loadTemplate($templateFileName,$variables = []){
    extract($variables);
    ob_start();
    include __DIR__ . '/../../templates/'. $templateFileName;
    return ob_get_clean();
  }

  private function parseUrl($url)
  {
    $parseUrl = parse_url($url);
    $parseUrl = ltrim($parseUrl["path"], "/");
    $parseUrl = trim($parseUrl);
    $parseUrl = rtrim($parseUrl,'/');
    $parseUrl = explode("/", $parseUrl);
    array_shift($parseUrl); //remove localhost Path "novice"
    $parseUrl = implode("/", $parseUrl);
    return $parseUrl;
  }
  public function run(){
    $routes = $this->routes->getRoutes();
    $authentication = $this->routes->getAuthentication();
    $this->route = $this->parseUrl($this->route);
    // echo "<pre>";
    ////var_dump($authentication->getUser());
    // echo  "<p>route url is =></p>";
    //  var_dump($this->route);
    // echo "</pre>";
    // exit("end of run authentication script");
    if (isset($routes[$this->route]['login']) && !$authentication->isLoggedIn()){
      header('location:/novice/login/error');
    }else if (isset($routes[$this->route]['permissions']) && !$this->routes->checkPermission($routes[$this->route]['permissions'])) {
      header('location:/novice/login/error');
    }
    else{
      // echo "<pre>";
      // echo "<p>{$this->route}</p>";
      // echo "<p>{$this->method}</p>";
      $controller = $routes[$this->route][$this->method]['controller'];
      // var_dump($controller);
      // echo "</pre>";
      // exit("before action => {$this->route}");
      $action = $routes[$this->route][$this->method]['action'];
      // exit("action is {$action} ");
      $page = $controller->$action();
      // echo "<pre>";
      // // var_dump($action);
      // // var_dump($this->route);
      // print_r($page);
      // echo "</pre>";
      // exit("end of run script");

      $title = $page['title'];

      if (isset($page['variables'])) {
        $output = $this->loadTemplate($page['template'],$page['variables']);
      }else{
        $output = $this->loadTemplate($page['template']);
      }
      echo $this->loadTemplate('layout.html.php',[ 'loggedIn'=>$authentication->isLoggedIn(),'title' => $title,'output' => $output]);
    }

  }

}