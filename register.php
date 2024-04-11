<?php
    // Author: Lauren Knight
    // Description: Registration page for new volunteers
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

    // if (isset($_SESSION['_id'])) {
    //     header('Location: index.php');
    // } else {
    //     $_SESSION['logged_in'] = 1;
    //     $_SESSION['access_level'] = 0;
    //     $_SESSION['venue'] = "";
    //     $_SESSION['type'] = "";
    //     $_SESSION['_id'] = "guest";
    //     header('Location: personEdit.php?id=new');
    // }
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <?php if ($_SESSION['system_type'] == 'MedTracker') {
        if ($_SESSION['access_level'] < 3) { ?>
    <title>ODHS Medicine Tracker | Create Volunteer <?php if ($loggedIn) echo ' New Volunteer' ?></title>
    <?php } else { ?>
    <title>ODHS Medicine Tracker | Create Account <?php if ($loggedIn) echo ' New Account' ?></title>
    <?php }
    } else {
        if ($_SESSION['access_level'] < 3) { ?> 
    <title>ODHS VMS | Create Volunteer <?php if ($loggedIn) echo ' New Volunteer' ?></title>
    <?php } else { ?>
    <title>ODHS VMS | Create Account <?php if ($loggedIn) echo ' New Account' ?></title>
    <?php }
    } ?>
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
                'first-name', 'last-name', 'birthdate',
                'address', 'city', 'state', 'zip', 
                'email', 'phone', 'phone-type', 'contact-when', 'contact-method',
                'start-date', 'password', 'type', 'gender'
            );
            $errors = false;
            if (!wereRequiredFieldsSubmitted($args, $required)) {
                $errors = true;
            }
            $first = $args['first-name'];
            $last = $args['last-name'];
            $dateOfBirth = validateDate($args['birthdate']);
            if (!$dateOfBirth) {
                $errors = true;
                echo 'bad dob';
            }

            $address = $args['address'];
            $city = $args['city'];
            $state = $args['state'];
            if (!valueConstrainedTo($state, array('AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA',
                    'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME',
                    'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM',
                    'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX',
                    'UT', 'VA', 'VT', 'WA', 'WI', 'WV', 'WY'))) {
                $errors = true;
            }
            $zipcode = $args['zip'];
            if (!validateZipcode($zipcode)) {
                $errors = true;
                echo 'bad zip';
            }
            $email = strtolower($args['email']);
            $email = validateEmail($email);
            if (!$email) {
                $errors = true;
                echo 'bad email';
            }
            $phone = validateAndFilterPhoneNumber($args['phone']);
            if (!$phone) {
                $errors = true;
                echo 'bad phone';
            }
            $phoneType = $args['phone-type'];
            if (!valueConstrainedTo($phoneType, array('cellphone', 'home', 'work'))) {
                $errors = true;
                echo 'bad phone type';
            }
            $contactWhen = $args['contact-when'];
            $contactMethod = $args['contact-method'];
            if (!valueConstrainedTo($contactMethod, array('phone', 'text', 'email'))) {
                $errors = true;
                echo 'bad contact method';
            }

            $econtactName = $args['econtact-name'];
            $econtactPhone = validateAndFilterPhoneNumber($args['econtact-phone']);
            if (!$econtactPhone) {
                $errors = true;
                echo 'bad e-contact phone';
            }
            $econtactRelation = $args['econtact-relation'];

            $startDate = validateDate($args['start-date']);
            if (!$startDate) {
                $errors = true;
                echo 'bad start date';
            }
            $gender = $args['gender'];
            if (!valueConstrainedTo($gender, ['Male', 'Female', 'Other'])) {
                $errors = true;
                echo 'bad gender';
            }

            // May want to enforce password requirements at this step
            $password = password_hash($args['password'], PASSWORD_BCRYPT);
            $type = $args['type'];

            if ($errors) {
                echo '<p>Your form submission contained unexpected input.</p>';
                die();
            }
            // need to incorporate availability here
            $newperson = new Person(
//first, last venue
		$first, $last, 'portland', 
//address, city state, zip code, profile picture
                $address, $city, $state, $zipcode, "",
//phone1, phone type, phone 2, phonetype 2, email
                $phone, $phoneType, null, null, $email, 
//contact name, contact number, contact relation
		$econtactName, $econtactPhone, $econtactRelation, 
//ct=contact when, type=t, status = st, ct=contact method 
                $contactWhen, $type, 'Active', $contactMethod, 
//hours array
		'', 
//bd=date of birth, sd=start date, notes password
                $dateOfBirth, $startDate, null, $password,
                0, $gender
            );
            $result = add_person($newperson);
            if (!$result) {
                echo '<p>That e-mail address is already in use.</p>';
            } else {
                if ($loggedIn) {
                    echo '<script>document.location = "VMS_index.php?registerSuccess";</script>';
                } else {
                    echo '<script>document.location = "login.php?registerSuccess";</script>';
                }
            }
        } else {
            if ($accessLevel < 3) {
                require_once('registrationForm.php'); 
            } else {
                require_once('mainRegistrationForm.php');
            }
        }
    ?>
</body>
</html>
