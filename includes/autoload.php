<?php
function autoloader($className){
  //echo "<p>className: $className</p>";
  $fileName = str_replace('\\', '/', $className) . '.php';
 // echo "<p>File name: $fileName</p>";
  $file = __DIR__ .'/../classes/' . $fileName;
  //echo "<p>File: $file</p>";
  include $file;
}
spl_autoload_register( 'autoloader');