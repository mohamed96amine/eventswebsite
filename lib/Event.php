<?php


class Event
{
    
    public $lat;
    public $lon;
    public $date;
    public $author;
    public $title;
    public $text;
    public $id;

    function __construct($lat, $lon, $date, $author, $title, $text, $id){
        $this ->lat = $lat;
        $this ->lon = $lon;
        $this ->date = $date;
        $this ->author = $author;
        $this ->title = $title;
        $this ->text = $text;
        $this ->id = $id;
    }

}

?>