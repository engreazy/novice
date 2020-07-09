<!DOCTYPE html>
<html>
<head>
  <title>jokes</title>
</head>
<body>
<p><a href="?addjoke">Add your own joke</a></p>
<p>Here are all the jokes in the database: </p>
<?php foreach($jokes as $joke):?>
  <form action="?deletejoke" method="post">
    <blockquote>
      <p>
        <?php
        echo htmlspecialchars($joke['joke'],ENT_QUOTES,'UTF-8');
        ?>
        <input type="hidden" name="id" value="<?php echo $joke['id'];?>">
        <input type="submit" value="Delete">
      </p>
    </blockquote>
  </form>
<?php endforeach;?>
</body>
</html>