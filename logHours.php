<?php
// Original Author: Lauren Knight
// Modified by: Joseph Vogtli (4/13/2024)

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
        require_once('domain/Hours.php');
        require_once('database/dbHours.php');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // make every submitted field SQL-safe except for password
            $ignoreList = array('password');
            $args = sanitize($_POST, $ignoreList);

            // echo "<p>The form was submitted:</p>";
            // foreach ($args as $key => $value) {
            //     echo "<p>$key: $value</p>";
            // }

            $required = array(
                'userEmail','duration'
            );
            $errors = false;
            if (!wereRequiredFieldsSubmitted($args, $required)) {
                $errors = true;
            }
            
            //Puts email into userEmail and checks validity
            $id = $args['userEmail'];
            if(!validateEmail($id)){
                $errors = true;
                echo 'Bad input in Volunteer Email';
            }

            //Error checks have to be after every validation check or else they won't work.
            if ($errors) {
                echo '<p>Your form submission contained unexpected input.</p>';
                die();
            }

            //Put these hours into dbHours with their date
            $hours = $args['duration'];
            if ($hours < 0) {
                $errors = true;
                echo 'Bad input in Volunteer Hours';
            }

            if ($errors) {
                echo '<p>Your form submission contained unexpected input.</p>';
                die();
            }

            $date = date('d-m-y');
            $time = date('h:i:s');
            $final = add_hours($id, $date, $time, $hours);

            echo "<h3> Hours successfully updated! </h3>";
            
        } else {
            require_once('logHoursForm.php'); 
        }
        //Allows Adoption Center user to go back on their Ipad 
    ?>
    <a class="button cancel" href="loghours.php">Return to form</a>
</body>
</html>