<?php
  $pdo = new PDO('mysql:host=localhost;dbname=ijdb','root','');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');