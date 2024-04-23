<?php
/*
 * @author John Leitch <jleitch@umw.edu>
 * Edited 4/18/24
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
    
?>

<html>
    <head>
        
        <meta HTTP-EQUIV="REFRESH" content="2; url=event.php?id=<?php echo $_GET['id'] ?>">
        

        <?php 
            require('universal.inc');
        ?>
    </head>
    <body>
        <nav>
            <span id="nav-top">
                <span class="logo">
                    <img src="images/gwynethsgift.png">
                        <span id="vms-logo"> VMS </span>
                        </span>
                    <img id="menu-toggle" src="images/menu.png">
                </span>
            </span>
        </nav>
        <main>
                <?php
                    require_once('database/dbEventsPersons.php');
                    $person_id = $_SESSION['_id'];
                    $event_id = $_GET['id'];
                    if (sign_up($event_id, $person_id)) {
                        echo "<p class='happy-toast centered'>Successfully signed up for the Event!.</p>";
                    } else {
                        echo "<p class='error-toast centered'>Could not sign up for the Event: check your email to see if you are already signed up!</p>";
                    }
                ?>

        </main>
    </body>
</html>