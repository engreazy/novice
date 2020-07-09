<?php
try {
  include __DIR__ . '/includes/autoload.php';
# things I am yet to fix
# path and instantiantion of all controllers should be fixed
# only appropriate controller should be instantiated
  $route =  $_SERVER['REQUEST_URI'] ?? ''; //if no route variable is set, use home
  // $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'),'/');
  $entryPoint = new \Ninja\EntryPoint($route,$_SERVER['REQUEST_METHOD'],new \Ijdb\IjdbRoutes());
  $entryPoint->run();

} catch (PDOException $e) {
  $title = 'An error has occured';
  $output = 'Database error : ' . $e->getMessage() . ' in ' .$e->getFile() . ' : ' . $e->getLine();
}
