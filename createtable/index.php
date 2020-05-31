<?php
include __DIR__ . '/../connect/index.php';
try{
  $sql = 'CREATE TABLE `joke`(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    joketext TEXT,
    jokedate DATE NOT NULL
)';
$pdo->exec($sql);
}catch(PDOException $e){
  $output = 'Error creating joke table: ' . $e->getMessage();
  include __DIR__ .'/output.html.php';
}
$output = 'Joke table successfully created.';
include __DIR__ . '/output.html.php';