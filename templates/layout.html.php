<!DOCTYPE html>
<html>
<head>
  <title><?=$title;?></title>
</head>
<body>
  <nav>
    <header>
      <h1>Internet Joke Database</h1>
    </header>
    <ul>
      <li><a href="/novice/">Home</a></li>
      <li><a href="/novice/joke/list">Joke List</a></li>
      <li><a href="/novice/joke/edit">Add a new Joke</a></li>
      <li><a href="/novice/author/register">Register New User</a></li>
      <li><a href="/novice/category/edit">Add category</a></li>
      <li><a href="/novice/category/list">Category List</a></li>
      <?php if($loggedIn):?>
      <li><a href="/novice/logout">Log out</a></li>
      <?php else: ?>
      <li><a href="/novice/login">Log in</a></li>
    <?php endif; ?>
    </ul>
  </nav>
  <main>
    <section><?=$output;?></section>
  </main>
<footer>&copy; IJDB 2017</footer>
</body>
</html>