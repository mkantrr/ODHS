<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");
    
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        if (isset($_SESSION['change-password'])) {
            header('Location: changePassword.php');
        } else {
            header('Location: login.php');
        }
        die();
    }
        
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    // Get date?
    if (isset($_SESSION['_id'])) {
        $person = retrieve_person($_SESSION['_id']);
    }
    $notRoot = $person->get_id() != 'vmsroot';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('universal.inc'); ?>
        <title>ODHS | Login</title>
    </head>
    <body>
        <?php require('header.php'); ?>
        <h1>ODHS Login</h1>
        <main class='dashboard'>
            <p>Welcome back, <?php echo $person->get_first_name()?> access level <?php echo $person->get_access_level ?>!</p>
            <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
            <div id="dashboard">
                <?php if ($_SESSION['access_level'] >= 2): ?>
                    <div class="dashboard-item" data-link="index.php">
                        <img src="images/index.svg">
                        <span>Go to MedTracker Dashboard</span>
                    </div>
                <?php endif ?>
                <div class="dashboard-item" data-link="VMS_index.php">
                    <img src="images/vms_index.svg">
                    <span>Go to Volunteer Management System Dashboard</span>
                </div>
                <div class="dashboard-item" data-link="logout.php">
                    <img src="images/logout.svg">
                    <span>Log out</span>
                </div>
            </div>
        </main>
    </body>
</html>