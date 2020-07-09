<style>
  .currentpage:before {
    content: "[";
  }
  .currentpage:after {
    content: "]";
  }
</style>
<pre>
  <?php
  // echo "<p>jokes</p>";
  // print_r($jokes);
  // echo "<p>categories</p>";
  // var_dump($categories);
  // exit("end jokes list script");
  ?>
</pre>
<div class="jokelist">
  <p>Categories</p>
  <ul>
    <?php foreach($categories as $category):?>
      <li><a href="/novice/joke/list/?category=<?=$category->id?>"><?=$category->name?></a></li>
    <?php endforeach; ?>
  </ul>
</div>
<p><?=$totalJokes?> jokes have been submitted to the internet Joke Database.</p>
<a href="/novice/joke/edit">Add Joke</a>
<?php foreach($jokes as $joke):?>
<blockquote>

    <?=(new \Ninja\Markdown($joke->joketext))->toHtml()?>

    (By <a href="mailto:<?php
      echo htmlspecialchars($joke->getAuthor()->email,
      ENT_QUOTES,
      'UTF-8');
    ?>"><?php
    echo htmlspecialchars(
      $joke->getAuthor()->name,
      ENT_QUOTES,
      'UTF-8'
    );
    ?></a> on
    <?php
    $date = new DateTime($joke->jokedate);
    echo $date->format('jS F Y');
    ?>)
    <?php if($user):?>
      <?php if($user->id == $joke->authorid || $user->hasPermission(\Ijdb\Entity\Author::EDIT_JOKES)): ?>
        <a href="/novice/joke/edit?id=<?=$joke->id?>">Edit</a>
      <?php endif; ?>
      <?php if($user->id == $joke->authorid || $user->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)):?>
        <form action="/novice/joke/delete" method="post" >
          <input type="hidden" name="id" value="<?=$joke->id?>">
          <input type="submit" value="Delete">
        </form>
      <?php endif; ?>
  <?php endif; ?>
</blockquote>
<?php endforeach; ?>
Select page:
<?php
$numPages = ceil($totalJokes/10);
  for ($i = 1; $i <= $numPages; $i++):
    if ($i == $currentPage):
?>
    <a class="currentpage"href="/novice/joke/list?page=<?=$i?><?=!empty($categoryid) ?'&category=' . $categoryid : '' ?>"><?=$i?></a>
<?php else: ?>
    <a href="/novice/joke/list?page=<?=$i?><?=!empty($categoryid) ?'&category=' . $categoryid : '' ?>"><?=$i?></a>
  <?php endif; ?>
<?php endfor; ?>