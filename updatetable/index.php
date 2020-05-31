<?php
include __DIR__ . '/../connect/index.php';
try {
  $sql = 'UPDATE `joke` SET
  `jokedate` = "2012-04-01"
  WHERE `joketext` LIKE "%programmer%"
  ';
  $affectedRows = $pdo->exec($sql);
} catch (PDOException $e) {
  $output =  'Error performing update: ' .$e->getMessage();
  include __DIR__ . '/output.html.php';
  exit();
}
$output = "Updated $affectedRows rows.";
include __DIR__ . '/output.html.php';