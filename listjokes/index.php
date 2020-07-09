<?php
  if(isset($_GET['addjoke'])){
    include __DIR__ .'/form.html.php';
    exit();
  }
  include __DIR__ . '/../connect/index.php';
  if(isset($_POST['joketext'])){
    try {
      $sql = 'INSERT INTO `joke` SET
      `joketext`= :joketext,
      `jokedate`= CURDATE()';
      $s = $pdo->prepare($sql);
      $s->bindValue(':joketext',$_POST['joketext']);
      $s->execute();
    } catch (PDOException $e) {
      $error = 'Error adding submitted joke: ' . $e->getMessage();
      include 'error.html.php';
    }
    header('Location: .');
    exit();
  }
  if (isset($_GET['deletejoke'])) {
    try {
      $sql = 'DELETE FROM joke WHERE id= :id';
      $s = $pdo->prepare($sql);
      $s->bindValue(':id',$_POST['id']);
      $s->execute();
    } catch (PDOException $e) {
      $error = 'Error deleting joke '. $e->getMessage();
      include 'error.html.php';
      exit();
    }
    header("Location: .");
    exit();
  }
  try {
  $sql = 'SELECT `joke`.`id`, `joketext`,`name`,`email` FROM
          `joke` INNER JOIN `author`
          ON `authorid` = `author`.`id`';
  $result = $pdo->query($sql);
  $title = 'Joke List';
  ob_start();
  include __DIR__ . '/jokes.html.php';
  $output = ob_get_clean();
  } catch (PDOException $e) {
    $title = 'An error has occured';
    $error = 'Error fetching jokes : '. $e->getMessage();
    include __DIR__ .'/error.html.php';
    exit();
  }

  // while($row = $result->fetch())
  // {
  //   $jokes[] = array('id' => $row['id'], 'text' => $row['joketext']);
  // }
  foreach ($result as $rows)
  {
    // print_r($result);
    // print_r( $rows );
    $jokes[] = array('id' => $rows['id'], 'joke' => $rows['joketext']);
  }

include __DIR__ . '/layout.html.php';
