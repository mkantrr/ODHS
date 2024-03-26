<?php

class Hours {
    private $id; //id, email of volunteer 
    private $timestamp; //timestamp of when the hours were logged
    private $duration; //how many hours volunteered
}

function __construct($timestamp, $duration) {
    $this->timestamp = $timestamp;
    $this->duration = $duration;
}

function get_timestamp() {
    return $this->timestamp;
}

function get_duration() {
    return $this->duration;
}
?>