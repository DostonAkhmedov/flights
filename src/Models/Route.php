<?php


namespace Szrcai\Flights\Models;


class Route
{
    private $name;
    private $registration;
    private $start;
    private $points = array();
    private $speed;

    public function __construct($name, $registration, $start, $speed)
    {
        $this->name = $name;
        $this->registration = $registration;
        $this->start = $start;
        $this->speed = $speed;
    }

    private function getPoints()
    {
        return $this->points;
    }

    private function setPoint($x, $y)
    {
        $this->points[] = new Point($x, $y);
    }
}
