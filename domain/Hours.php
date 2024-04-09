<?php

class Hours {
    private $id; //id
    private $email; //email of user logging hours
    private $date; //date of the hour logged
    private $time; //time of the hour logged
    private $duration; //how many hours volunteered
}

function __construct($email, $timestamp, $duration) {
    $this->email = $email;
    $this->timestamp = $timestamp;
    $this->duration = $duration;
}

function get_id() {
    return $this->id;
}

function get_email() {
    return $this->email;
}

function get_date() {
    return $this->date;
}

function get_time() {
    return $this->time;
}

function get_duration() {
    return $this->duration;
}

?>