<?php

class Hours {
    private $id; //id
    private $email; //email of user logging hours
    private $timestamp; //timestamp of when the hours were logged
    private $duration; //how many hours volunteered
}

function __construct($timestamp, $duration) {
    $this->timestamp = $timestamp;
    $this->duration = $duration;
}

function get_email() {
    return $this->email;
}

function get_timestamp() {
    return $this->timestamp;
}

function get_duration() {
    return $this->duration;
}
?>