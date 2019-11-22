<?php


namespace Szrcai\Flights\Models;


class Route
{
    /**
     * The radius of Earth
     * @var float
     */
    const EARTH_RADIUS = 6371.230;

    /**
     * Least number of points
     * @var int
     */
    const MIN_POINTS = 2; // start and finish

    /**
     * The name of plane
     * @var string
     */
    public $name;

    /**
     * Registration number
     * @var string
     */
    public $registration;

    /**
     * Flight number
     * @var string
     */
    public $number;

    /**
     * Departure time
     * @var string
     */
    public $start;

    /**
     * The speed of plane
     * @var int
     */
    public $speed;

    /**
     * The list of points
     * @var array
     */
    private $points = array();

    /**
     * Route constructor.
     * @param $name
     * @param $registration
     */
    public function __construct($name, $registration)
    {
        $this->name = $name;
        $this->registration = $registration;
    }

    /**
     * Set flight number
     * @param $number
     * @return Route
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Set flight start time
     * @param $start
     * @return Route
     */
    public function setStartTime($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Set speed for flight
     * @param $speed
     * @return Route
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Return list of points
     * @return array
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Return count of points
     * @return int
     */
    public function getCountPoints()
    {
        return count($this->points);
    }

    /**
     * Add new point to route
     * @param $lat
     * @param $lon
     * @return $this
     */
    public function addPoint($lat, $lon)
    {
        $this->points[] = new Location($lat, $lon);

        return $this;
    }

    /**
     * Return distance of the route
     * @return float
     */
    public function getDistance()
    {
        $distance = 0;
        $cntPoints = $this->getCountPoints();
        for ($i = 1; $i < $cntPoints; $i++) {
            $distance += $this->getPartDistance($i);
        }
        return $distance;
    }

    /**
     * Calculate and return distance of part of the route
     * @param $leg
     * @return float
     */
    public function getPartDistance($leg)
    {
        $points = $this->getPoints();
        $loc1 = $points[$leg];
        $loc2 = $points[$leg - 1];
        $lat1 = $loc1->latitude;
        $lon1 = $loc1->longitude;
        $lat2 = $loc2->latitude;
        $lon2 = $loc2->longitude;

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

    /**
     * Return finish time
     * @return string
     * @throws \Exception
     */
    public function finishTime()
    {
        return $this->calcFinishTime(
            $this->getDistance()
        );
    }

    /**
     * Return finish time for part of the route
     * @param $point
     * @return string
     * @throws \Exception
     */
    public function partFinishTime($point)
    {
        $distance = 0;
        for ($i = 1; $i <= $point; $i++) {
            $distance += $this->getPartDistance($i);
        }

        return $this->calcFinishTime($distance);
    }

    /**
     * Calculate finish time by distance
     * @param $distance
     * @return string
     * @throws \Exception
     */
    private function calcFinishTime($distance)
    {
        $startTime = $this->start;
        $speed = $this->speed;
        $flightTimeS = round(($distance / $speed) * 60 * 60);
        try {
            $interval = new \DateInterval('PT' . intval($flightTimeS) . 'S');
            $time = new \DateTime($startTime);
            $time = $time->add($interval);

            return $time->format("Y-m-d H:i");
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
