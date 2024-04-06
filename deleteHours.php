<?php
/*
 * Edited by Joseph Vogtli 4/5/2024
 * Deletes hours via a link in the view hours table
 */
?>
<?php
/*
 * Created on Mar 28, 2008
 * @author Oliver Radwan <oradwan@bowdoin.edu>
 */
?>
<?PHP
session_cache_expire(30);
session_start();

$loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    $isAdmin = false;
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        header('Location: login.php');
        die();
    }
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $isAdmin = $accessLevel >= 2;
        $userID = $_SESSION['_id'];
    } else {
        header('Location: login.php');
        die();
    }
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = strtolower($args['id']);
    } else {
        $id = $userID;
    }
    
?>
<!-- page generated by the BowdoinRMH software package -->
<html>
    <head>
        <meta HTTP-EQUIV="REFRESH" content="2; url=index.php">

        <?php require('universal.inc') ?>
    </head>
    <body>
        <nav>
            <span id="nav-top">
                <span class="logo">
                    <img src="images/gwynethsgift.png">
                        <span id="vms-logo"> MedTracker </span>
                        </span>
                    <img id="menu-toggle" src="images/menu.png">
                </span>
            </span>
        </nav>
        <main>
                <p class="happy-toast centered">This has been deleted.</p>
                <?php
                //Should remove the selected hours
                //Not functional as of now
                //remove_hours($hours->get_id());
                ?>
        </main>
    </body>
</html>