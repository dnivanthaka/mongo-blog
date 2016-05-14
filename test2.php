<?php
require_once('Session.php');

echo 'Generated number is '.$_SESSION['random_number'];

session_destroy();
?>