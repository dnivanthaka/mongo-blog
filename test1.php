<?php
require_once('Session.php');

$_SESSION['random_number'] = rand();

echo $_SESSION['random_number'].'<br />';
echo session_id();
?>