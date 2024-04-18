<?php

/** Author: John Leitch
 * Last modified: 4/18/24
 */

  include_once('dbinfo.php');
  include_once('dbEvents.php');
  include_once(dirname(__FILE__).'/../domain/Event.php');
  include_once(dirname(__FILE__).'/../domain/Person.php');

/**
 * Sign up a Volunteer for an Event, adding an entry of the Person ID and Event ID, then return True. If such an entry
 * already exists, return False.
 */
function sign_up($person_id, $email_id) {
    $con=connect();
    $query = "SELECT * FROM dbEventsPersons WHERE date = '" . $date . "' AND time = ' . $time . '";
    $result = mysqli_query($con,$query);
    //if there's no entry for this id, add it
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_query($con, 'INSERT INTO dbHours (hourID, userEmail, date, time, duration) VALUES(
            NULL, "' .
            $email . '","' .
            $date . '","' .
            $time . '","' .
            $duration . '");'
        );
        mysqli_close($con);
        return true;
    }
    mysqli_close($con);
    return false;
}

/**
 * Remove an hour from dbHours table, if it doesn't exist, return false
 */
function remove_hours($id) {
    $con=connect();
    $query = "SELECT * FROM dbHours WHERE hourID = " . $id . "";
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $query = "DELETE FROM dbHours WHERE hourID = " . $id . "";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return true;
}

/**
 * Return an array of hours logged by a given email
 */
function retrieve_hours_by_email($email) {
	if (!isset($email) || $email == "" || $email == null) return $hours;
	$con=connect();
    $query = "SELECT * FROM dbHours WHERE userEmail = '" . $email .  "'  ORDER BY date, time";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;	
}

/**
 * Return the sum of all logged hour durations from a specific user
 */
function total_hours($email) {
    $con=connect();
    $query = "SELECT SUM(duration) FROM dbHours WHERE userEmail = '" . $email . "'";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}

?>

?>