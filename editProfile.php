<?php
    // Author: Lauren Knight
    // Description: Profile edit page
    session_cache_expire(30);
    session_start();
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    if (!isset($_SESSION['_id'])) {
        header('Location: login.php');
        die();
    }

    require_once('include/input-validation.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modify_access"]) && isset($_POST["id"])) {
        $id = $_POST['id'];
        header("Location: modifyUserRole.php?id=$id");
    } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["profile-edit-form"])) {
        require_once('domain/Person.php');
        require_once('database/dbPersons.php');
        // make every submitted field SQL-safe except for password
        $ignoreList = array('password');
        $args = sanitize($_POST, $ignoreList);

        $editingSelf = true;
        if ($_SESSION['access_level'] >= 2 && isset($_POST['id'])) {
            $id = $_POST['id'];
            $editingSelf = $id == $_SESSION['_id'];
            $id = $args['id'];
            // Check to see if user is a lower-level manager here
        } else {
            $id = $_SESSION['_id'];
        }

        // echo "<p>The form was submitted:</p>";
        // foreach ($args as $key => $value) {
        //     echo "<p>$key: $value</p>";
        // }

        $required = array(
            'first-name', 'last-name', 'birthdate',
            'address', 'city', 'state', 'zip', 
            'email', 'phone', 'phone-type', 'contact-when', 'contact-method',
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
            // echo 'bad dob';
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
            // echo 'bad zip';
        }

        $email = validateEmail($args['email']);
        if (!$email) {
            $errors = true;
            // echo 'bad email';
        }
        $phone = validateAndFilterPhoneNumber($args['phone']);
        if (!$phone) {
            $errors = true;
            // echo 'bad phone';
        }
        $phoneType = $args['phone-type'];
        if (!valueConstrainedTo($phoneType, array('cellphone', 'home', 'work'))) {
            $errors = true;
            // echo 'bad phone type';
        }
        $contactWhen = $args['contact-when'];
        $contactMethod = $args['contact-method'];
        if (!valueConstrainedTo($contactMethod, array('phone', 'text', 'email'))) {
            $errors = true;
            // echo 'bad contact method';
        }

        $econtactName = $args['econtact-name'];
        $econtactPhone = validateAndFilterPhoneNumber($args['econtact-phone']);
        if (!$econtactPhone) {
            $errors = true;
            // echo 'bad e-contact phone';
        }
        $econtactRelation = $args['econtact-relation'];

        $gender = $args['gender'];
        if (!valueConstrainedTo($gender, ['Male', 'Female', 'Other'])) {
            $errors = true;
            echo 'bad gender';
        }

        if ($errors) {
            $updateSuccess = false;
        }
        
        $result = update_person_profile($id,
            $first, $last, $dateOfBirth, $address, $city, $state, $zipcode,
            $email, $phone, $phoneType, $contactWhen, $contactMethod, 
            $econtactName, $econtactPhone, $econtactRelation, $gender
        );
        if ($result) {
            if ($editingSelf) {
                header('Location: viewProfile.php?editSuccess');
            } else {
                header('Location: viewProfile.php?editSuccess&id='. $id);
            }
            die();
        }

    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <?php if ($_SESSION['system_type'] == 'MedTracker') { ?>
    <title>ODHS Medicine Tracker | Manage Profile</title>
    <?php } else { ?>
    <title> ODHS VMS | Manage Profile </title>
    <?php } ?>
</head>
<body>
    <?php
        require_once('header.php');
        $isAdmin = $_SESSION['access_level'] >= 2;
        require_once('profileEditForm.inc');
    ?>
</body>
</html>
