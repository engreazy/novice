<style>
/*form p {clear: both;}
input[type="checkbox"] {float: left; clear: left; width:auto; margin-right: 10px;}
input[type="checkbox"] + label {clear: right;}*/
</style>
<?php
// echo "<pre>";
// print_r($userId);
// print_r($joke['authorid']);
// echo "</pre>";
?>

<?php //if($userId == $joke['authorid']):?>
<!--check if user is logged in -->
<?php if(empty($joke->id) || $user->id == $joke->authorid || $user->hasPermission(\Ijdb\Entity\Author::EDIT_JOKES)):?>
<form action="" method="post">
  <!--need to check if userId == Joke['authorid'] before echoing the values for edit-->
<input type="hidden" name="joke[id]" value="<?=$joke->id ?? ''?>">
<p>Select categories for this joke: </p>
<?php foreach($categories as $category): ?>
  <?php
    if ($joke && $joke->hasCategory($category->id)):
  ?>
  <input type="checkbox" checked name="category[]" value="<?=$category->id?>">
<?php else: ?>
  <input type="checkbox" name="category[]" value="<?=$category->id?>" />
<?php endif; ?>
  <label><?=$category->name?></label>
<?php
    endforeach; ?>
<br>
<label for="joketext">Type your joke here:</label>
<textarea id="joketext" name="joke[joketext]" rows="3" cols="40"><?=$joke->joketext ?? ''?></textarea>
<p>Select categories for this joke: </p>
<?php foreach($categories as $category):?>
  <input type="checkbox" name="category[]" value="<?=$category->id?>">
  <label for="<?=$category->name?>"><?=$category->name?></label><br>
<?php endforeach; ?>
<input type="submit" value="Save">
</form>
<?php else: ?>
<p>You may only edit jokes that you posted.</p>
<?php endif; ?>