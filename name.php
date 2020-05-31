<?php
if (isset($_GET)) {
    echo "<pre>";
    print_r($_GET);
    echo "</pre>";
  # code...
}
function SplitEmailAddress($email){
  $pieces = explode('@', $email);
  $arr['user']=$pieces[0];
  $arr['domain']=$pieces[1];
  return $arr;
}
// $adminEmail =SplitEmailAddress($_GET['email']);
// echo "<pre>";
// print_r($adminEmail);
// echo "</pre>";
// $getSendMail[] = $adminEmail['user'];
// $getSendMail[] = $adminEmail['domain'];
// $changeName = $adminEmail['user'];
// echo $changeName;
// $sendMail = implode('@', $getSendMail);
// echo "sendMail is => $sendMail";
$tunde = 'tunde';
$kola = 'kola';
$sentence = ' This is a very good '. $tunde .'  and '. $kola;
$sentence .= ' the test continues';
$tunde = 'Samuel is my new name ';
$sentence .= ' The end ';
echo $sentence;