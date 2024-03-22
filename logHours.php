<?php
// Original Author: Lauren Knight
// Modified by: Joseph Vogtli (3/22/2024)
    // Description: Logging Hours that a Volunteer has worked
    session_cache_expire(30);
    session_start();
    
    require_once('include/input-validation.php');

    $loggedIn = false;
    if (isset($_SESSION['change-password'])) {
        header('Location: changePassword.php');
        die();
    }
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }

    // Require admin privileges
    if ($accessLevel < 2)
    {
        header('Location: login.php');
        echo 'bad access level';
        die();
    }

?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>ODHS Medicine Tracker | Register <?php if ($loggedIn) echo 'Adoption Center Login' ?></title>
</head>
<body>
    <?php
        require_once('header.php');
        require_once('domain/Person.php');
        require_once('database/dbPersons.php');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // make every submitted field SQL-safe except for password
            $ignoreList = array('password');
            $args = sanitize($_POST, $ignoreList);

            // echo "<p>The form was submitted:</p>";
            // foreach ($args as $key => $value) {
            //     echo "<p>$key: $value</p>";
            // }

            $required = array(
                'email','hours-vol'
            );
            $errors = false;
            if (!wereRequiredFieldsSubmitted($args, $required)) {
                $errors = true;
            }
            
            $id = $args['email'];

            //Compunds new hours with hours already in database
            $sum_hours = retrieve_hours($id) + $args['hours-vol'];
            $hours = update_hours($id, $sum_hours);
            if (!$hours) {
                $errors = true;
                echo 'bad hours';
            }

            if ($errors) {
                echo '<p>Your form submission contained unexpected input.</p>';
                die();
            }

            echo "<h3> Hours successfully updated! </h3>";
            
        } else {
            require_once('logHoursForm.php'); 
        }
    ?>
</body>
</html>