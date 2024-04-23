<?php 

    session_cache_expire(30);
    session_start();

    // Ensure user is logged in
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        header('Location: login.php');
        die();
    }
    require_once('include/input-validation.php');
    $args = sanitize($_GET);
    if (isset($args["id"])) {
        $id = $args["id"];
    } else {
        header('Location: calendar.php');
        die();
    }
  	
  	include_once('database/dbEvents.php');
  	
    // We need to check for a bad ID here before we query the db
    // otherwise we may be vulnerable to SQL injection(!)
    $event_info = fetch_event_by_id($id);
    if ($event_info == NULL) {
        // TODO: Need to create error page for no event found
        // header('Location: calendar.php');

        // Lauren: changing this to a more specific error message for testing
        echo 'bad event ID';
        die();
    }

    include_once('database/dbPersons.php');
    $access_level = $_SESSION['access_level'];
    $user = retrieve_person($_SESSION['_id']);
    $active = $user->get_status() == 'Active';
    include_once('database/dbEventsPersons.php');

?>

<!DOCTYPE html>
<html>

<head>
    <?php require_once('universal.inc'); ?>
    <title> ODHS VMS | Sign Up for Event: <?php echo $event_info['name'] ?></title>
</head>
    <body>
        <?php require_once('header.php'); ?>
        <h1>Sign Up for Event</h1>
        <main class="date">
            <h2>Sign Up for <?php echo $event_info['name'] ?></h2>
            <form id="sign-up-form" method="post">
                <a class="button" href="eventSignUp.php?id=<?php echo $id ?>" style="margin-top">Confirm Event Sign-Up</a>
                <a class="button cancel" href="calendar.php" style="margin-top">Return to Calendar</a>
                <a class="button cancel" href="vms_index.php" style="margin-top">Return to Dashboard</a>
        </main>
    </body>
</html>