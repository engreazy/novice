<?php
echo "<pre>";
var_dump($_GET);
echo "</pre>";
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
echo 'Welcome to our website, ' .htmlspecialchars($firstName,ENT_QUOTES,'UTF-8') .
' ' .htmlspecialchars($lastName, ENT_QUOTES,'UTF-8') .
'!';