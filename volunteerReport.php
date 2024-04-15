<?php
    //Created by Niko Toro
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }
    if (!$loggedIn) {
        header('Location: login.php');
        die();
    }
    $isAdmin = $accessLevel >= 2;
    require_once('database/dbPersons.php');
    require_once('database/dbHours.php');
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = $args['id'];
        $viewingSelf = $id == $userID;
    } else {
        $id = $_SESSION['_id'];
        $viewingSelf = true;
    }
    $volunteer = retrieve_person($id);
    $volunteerName = get_name_from_id($id);
    $email = get_email_from_id($id);
    $totalHours = total_hours($email);
    $hours = retrieve_hours_by_email($email);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>ODHS Medicine Tracker | Volunteer History</title>
        <link rel="stylesheet" href="css/hours-report.css">
    </head>
    <body>
        <?php 
            require_once('header.php');
        ?>
        <h1>Volunteer History Report</h1>
        <main class="hours-report">
            <?php if (!$volunteer): ?>
                <p class="error-toast">That volunteer does not exist!</p>
            <?php elseif ($viewingSelf): ?>
                <h1 class="no-print"><?php echo $volunteerName . "'s Volunteer Hours"?></h2>
            <?php else: ?>
                <h1 class="no-print">Hours Volunteered by <?php echo $volunteer->get_first_name() . ' ' . $volunteer->get_last_name() ?></h2>
            <?php endif ?>
            <h1 class="print-only">Hours Volunteered by <?php echo $volunteer->get_first_name() . ' ' . $volunteer->get_last_name() ?></h2>
            
            <?php if (mysqli_fetch_assoc($hours) != NULL): ?>
                <div class="table-wrapper"><table class="general">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Hours Logged</th>
                            <th>Delete?</th>
                        </tr>
                    </thead>
                    <tbody class="standout">

                <?php
                require_once('include/output.php');
                while ($result_row = mysqli_fetch_assoc($hours)) {
                    $field1name = $result_row["date"];
                    $field2name = $result_row["time"];
                    $field3name = $result_row["duration"];
                    $field4name = $result_row["hourID"];
                    
                    //Come back to "deleteHours.php" later, may cause future issues if not tested?
                    echo 
                    '<tr>
                        <td>' . $field1name . '</td>
                        <td>' . $field2name . '</td>
                        <td>' . $field3name . '</td>
                        <td><a href="deleteHours.php?hourID=' . $field4name . '">Delete</a></td>
                    </tr>';
                }
    
                while ($result_row = mysqli_fetch_assoc($totalHours)) {
                    $field1name = $result_row["SUM(duration)"];
                    echo 
                    '<tr class="total-hours">
                        <td></td><td class="total-hours">Total Hours</td>
                        <td>' . $field1name . '</td>
                    </tr>';
                }
                ?>

            <?php else: ?>
                <?php echo 'Whoops! Looks like you don\'t have any hours to view!'; ?>
            <?php endif ?>
        </main>
    </body>
</html>
