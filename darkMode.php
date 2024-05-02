<?php
 session_cache_expire(30);
 session_start();
if($_SESSION['dark_mode'] == true)
{$_SESSION['dark_mode'] = false;}
else
$_SESSION['dark_mode'] = true;

if ($_SESSION['system_type'] == "MedTracker") {
    header('Location: index.php');
} else {
    header('Location: VMS_index.php');
}

?>