<?php
 session_cache_expire(30);
 session_start();
if($_SESSION['dark_mode'] == true)
{$_SESSION['dark_mode'] = false;}
else
$_SESSION['dark_mode'] = true;
header('Location: index.php');

?>