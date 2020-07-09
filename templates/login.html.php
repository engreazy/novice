<?php
if (isset($error)):
  echo '<div class="errors">' . $error .'</div>';
endif;
?>
<h3>Sign In </h3>
<form method="post" action="">
  <label for="email">Your email address</label>
  <input type="text" id="email" name="email"><br>
  <label for="password">Your password</label>
  <input type="password" id="password" name="password"><br>
  <input type="submit" name="login" value="Log in">
</form>
<p>Don't have an account? <a  href="/novice/author/register">Click here to register an account</a></p>