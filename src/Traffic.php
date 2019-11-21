<?php


namespace Szrcai\Flights;


use Cassandra\Date;
use Szrcai\Flights\Models\Route;

class Traffic
{
    private $routes = array();

    public function loadData($dataPath)
    {
        $data = (new Data($dataPath))->load();
        if ($data["routes"]) {
            foreach ($data["routes"] as $id => $route) {
                $newRoute = new Route($route["name"], $route["registration"]);
                $newRoute->setStartTime($route["start"])
                    ->setSpeed($route["speed"])
                    ->setNumber($id);
                if ($route["tr"]) {
                    foreach ($route["tr"] as $point) {
                        $newRoute->setPoint($point[0], $point[1]);
                    }
                }
                $this->routes[$newRoute->getNumber()] = $newRoute;
            }
        }
    }

    public function setRoute(Route $route)
    {
        $this->routes[$route->getNumber()] = $route;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function distance($number)
    {
        try {
            $route = $this->getRoute($number);
            $points = $route->getPoints();
            $distance = 0;
            if (count($points) >= 2) {
                for ($i = 1; $i < count($points); $i++) {
                    $distance += $route->getDistance($points[$i], $points[$i - 1]);
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $distance;
    }

    public function timeArrival($number)
    {
        try {
            $route = $this->getRoute($number);
            $distance = $this->distance($number);
            $time = $route->getFinishTime($distance, $route->getSpeed(), $route->getStartTime());
        } catch (\Exception $e) {
            throw $e;
        }

        return $time;
    }

    public function partDistance($number, $leg)
    {
        try {
            $route = $this->getRoute($number);
            $points = $route->getPoints();
            $distance = 0;
            if (count($points) >= 2) {
                $distance = $route->getDistance($points[$leg], $points[$leg - 1]);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $distance;
    }

    public function partTimeArrival($number, $point)
    {
        try {
            $route = $this->getRoute($number);
            $time = $route->getStartTime();
            for ($i = 1; $i <= $point; $i++) {
                $startTime = $time;
                $distance = $this->partDistance($number, $i);
                $time = $route->getFinishTime($distance, $route->getSpeed(), $startTime);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $time;
    }

    public function inAir(\DateTime $date = null)
    {
        $result = array();
        if (is_null($date)) {
            $date = new \DateTime();
        }
        foreach ($this->routes as $route) {
            $finishDate = new \DateTime($this->timeArrival($route->getNumber()));
            if ($finishDate > $date) {
                $result[] = $route;
            }
        }

        return $result;
    }

    protected function getRoute($number)
    {
        if (isset($this->routes[$number])) {
            return $this->routes[$number];
        }

        throw new \Exception("Route $number is not found!");
    }
}
