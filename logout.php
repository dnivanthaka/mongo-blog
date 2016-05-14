<?php
require_once('DBHandling.php');
require_once('Session.php');
require_once('User.php');

$user = new User();
$user->logout();
header('Location: index.php');
exit();