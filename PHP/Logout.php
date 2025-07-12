<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: ../Page/index.php");
exit;
?>