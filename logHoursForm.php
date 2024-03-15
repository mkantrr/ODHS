<?php

function buildSelect($name, $disabled=false, $selected=null) {
    global $times;
    global $values;
    if ($disabled) {
        $select = '
            <select id="' . $name . '" name="' . $name . '" disabled>';
    } else {
        $select = '
            <select id="' . $name . '" name="' . $name . '">';
    }
    if (!$selected) {
        $select .= '<option disabled selected value>Select a time</option>';
    }
    $n = count($times);
    for ($i = 0; $i < $n; $i++) {
        $value = $values[$i];
        if ($selected == $value) {
            $select .= '
                <option value="' . $values[$i] . '" selected>' . $times[$i] . '</option>';
        } else {
            $select .= '
                <option value="' . $values[$i] . '">' . $times[$i] . '</option>';
        }
    }
    $select .= '</select>';
    return $select;
}
?>

<h1>Log Volunteer Hours</h1>
<main class="signup-form">
    <form class="signup-form" method="post">
        <h2>Log Hours Form</h2>
        <p>Please fill out each section of the following form if you would like to volunteer for the organization.</p>
        <p>An asterisk (<em>*</em>) indicates a required field.</p>
        <fieldset>
            <legend>Personal Information</legend>
            <p>The following information will help us identify you within our system.</p>
            <label for="first-name"><em>* </em>First Name</label>
            <input type="text" id="first-name" name="first-name" required placeholder="Enter your first name">

            <label for="last-name"><em>* </em>Last Name</label>
            <input type="text" id="last-name" name="last-name" required placeholder="Enter your last name">

            <label for="hours-vol"><em>* </em>Hours Volunteered</label>
            <input type="text" id="hours-vol" name="hours-vol" required placeholder="Enter your volunteer hours">

            <!--
            Use this to connect users via phone number elsewhere 
            
            <label for="phone"><em>* </em>Phone Number</label>
            <input type="tel" id="phone" name="phone" pattern="\([0-9]{3}\) [0-9]{3}-[0-9]{4}" required placeholder="Ex. (555) 555-5555"> 
            -->


        </fieldset>

        <p>By pressing Submit below, you are agreeing to volunteer for the organization.</p>
        <input type="submit" name="registration-form" value="Submit">
    </form>
    <?php if ($loggedIn): ?>
        <a class="button cancel" href="index.php" style="margin-top: .5rem">Cancel</a>
    <?php endif ?>
</main>