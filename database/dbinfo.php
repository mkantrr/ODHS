<?php
/*
 * Copyright 2015 by Allen Tucker. 
 * This program is part of RMHP-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/*
 * This file is only the connection information for the database.
 * This file will be modified for every installation.
 * @author Max Palmer <mpalmer@bowdoin.edu>
 * @version updated 2/12/08
 */

function connect_md() {
    $host = "localhost"; 
    $database = "odhsmd";
    $user = "odhsvms";
    $pass = "odhsvms";
    if ($_SERVER['SERVER_NAME'] == 'jenniferp122.sg-host.com') {
        $user = 'uc1op8sb8zdqp';
        $database = 'dbav93qrin0kry';
        $pass = "7f8r0d57ltxn";
    } else if ($_SERVER['SERVER_NAME'] == 'gwynethsgiftvms.org') {
        $user = "uybhc603shfl5";
        $pass = "f11kwvhy4yic";
        $database = "dbwgyuabseaoih";
    }
    $con = mysqli_connect($host,$user,$pass,$database);
    if (!$con) { echo "not connected to server"; return mysqli_error($con);}
    $selected = mysqli_select_db($con,$database);
    if (!$selected) { echo "database not selected"; return mysqli_error($con); }
    else return $con;
    
}

function connect_vms() {
    $host = "localhost"; 
    $database = "odhsvms";
    $user = "odhsvms";
    $pass = "odhsvms";
    if ($_SERVER['SERVER_NAME'] == 'jenniferp122.sg-host.com') {
        $user = 'uc1op8sb8zdqp';
        $database = 'dbv3lnjdtwy4ks';
        $pass = "7f8r0d57ltxn";
    } else if ($_SERVER['SERVER_NAME'] == 'gwynethsgiftvms.org') {
        $user = "uybhc603shfl5";
        $pass = "f11kwvhy4yic";
        $database = "dbwgyuabseaoih";
    }
    $con = mysqli_connect($host,$user,$pass,$database);
    if (!$con) { echo "not connected to server"; return mysqli_error($con);}
    $selected = mysqli_select_db($con,$database);
    if (!$selected) { echo "database not selected"; return mysqli_error($con); }
    else return $con;
    
}

function connect() {
    if (isset($_SESSION) && $_SESSION['system_type'] == 'MedTracker') {
        connect_md();
    } else {
        connect_vms();
    }
}

?>
