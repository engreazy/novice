<?php
try {
  $sql = 'SELECT `joketext`
  FROM `joke`';
  $result = $pdo->query($sql);
} catch (PDOException $e) {
  $error = 'Error fetching jokes : '. $e->getMessage();
  include __DIR__ .'/error.html.php';
  exit();
}