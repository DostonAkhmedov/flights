<?php


namespace Szrcai\Flights\Models;


class Route
{
    const EARTH_RADIUS = 6371.230;

    private $number;
    private $name;
    private $registration;
    private $start;
    private $points = array();
    private $speed;

    public function __construct($name, $registration)
    {
        $this->name = $name;
        $this->registration = $registration;
    }

    public function getStartTime()
    {
        return $this->start;
    }

    public function setStartTime($datetime)
    {
        $this->start = $datetime;

        return $this;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoint($lat, $lon)
    {
        $this->points[] = new Location($lat, $lon);

        return $this;
    }

    public function getDistance(Location $loc1, Location $loc2)
    {
        $lat1 = $loc1->getLatitude();
        $lon1 = $loc1->getLongitude();
        $lat2 = $loc2->getLatitude();
        $lon2 = $loc2->getLongitude();

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = self::EARTH_RADIUS * $c;

        return $distance;
    }

    public function getFinishTime($distance, $speed, $startTime)
    {
        $flightTimeS = round(($distance / $speed) * 60 * 60);
        $interval = new \DateInterval('PT'.intval($flightTimeS).'S');
        $time = new \DateTime($startTime);
        $time = $time->add($interval);

        return $time->format("Y-m-d H:i");
    }
}
