<?php


namespace Szrcai\Flights\Models;


class Location
{
    /**
     * The north–south position of a point on the Earth's surface
     * @var int
     */
    public $latitude;

    /**
     * The east–west position of a point on the Earth's surface
     * @var int
     */
    public $longitude;

    /**
     * Location constructor.
     * @param $latitude
     * @param $longitude
     */
    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
