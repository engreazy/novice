<?php
try {
  include __DIR__ . '/../includes/autoload.php';

  $route =  $_GET['route'] ?? ''; //if no route variable is set, use home
  // $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'),'/');
  $entryPoint = new \Ninja\EntryPoint($route,$_SERVER['REQUEST_METHOD'],new \Ijdb\IjdbRoutes());
  $entryPoint->run();

} catch (PDOException $e) {
  $title = 'An error has occured';
  $output = 'Database error : ' . $e->getMessage() . ' in ' .$e->getFile() . ' : ' . $e->getLine();
}
