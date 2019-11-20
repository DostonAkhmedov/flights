<?php


namespace Szrcai\Flights\Models;


class Point
{
    private $x, $y;
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}