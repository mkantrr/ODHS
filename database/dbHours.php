<?php

include_once('dbinfo.php');
include_once(dirname(__FILE__).'/../domain/Hours.php');

/**
 * Add an hour to dbHours table, if already there, return false
 */
function add_hours($hours) {
    if (!$hours instanceof Hours)
        die("Error: add_hours type mismatch");
    $con=connect();
    $query = "SELECT * FROM dbHours WHERE id = '" . $hours->get_id() . "'";
    $result = mysqli_query($con,$query);
    //if there's no entry for this id, add it
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_query($con, 'INSERT INTO dbhours VALUES("' .
            $hours->get_id() . '","' .
            $hours->get_email() . '","' .
            $hours->get_timestamp() . '","' .
            $hours->get_duration() . '");'
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
    $query = 'SELECT * FROM dbHours WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $query = 'DELETE FROM dbHours WHERE id = "' . $id . '"';
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
    $query = "SELECT * FROM dbHours WHERE userEmail = '" . $email .  "'  ORDER BY timestamp";
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