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
function sign_up($event_id, $person_id) {
    $con=connect();
    $query = "SELECT * FROM dbEventsPersons WHERE event_id = $event_id AND person_id = '" . $person_id . "'";
    $result = mysqli_query($con,$query);
    //if there's no entry for this id, add it
    if ($result == null || mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO dbeventspersons (event_id, person_id) VALUES($event_id, '" . $person_id . "')";
        mysqli_query($con, $query);
        mysqli_close($con);
        return true;
    }
    mysqli_close($con);
    return false;
}

/**
 * Remove an hour from dbHours table, if it doesn't exist, return false
 */
function remove_sign_up($event_id, $person_id) {
    $con=connect();
    $query = "SELECT * FROM dbeventspersons WHERE event_id = ' . $event_id . ' AND person_id = '" . $person_id . "'";
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $query = "DELETE FROM dbeventspersons WHERE event_id = ' . $event_id . ' AND person_id = '" . $person_id . "'";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return true;
}

/**
 * Return an array of events signed up for by a given person
 */
function retrieve_events_by_person($person_id) {
    $query = "SELECT * FROM dbeventspersons WHERE person_id = '" . $person_id .  "'";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;	
}

/**
 * Return an array of persons signed up for a given event
 */
function retrieve_persons_by_event($event_id) {
    $query = "SELECT * FROM dbeventspersons WHERE event_id = ' . $event_id .  '";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;	
}


?>

