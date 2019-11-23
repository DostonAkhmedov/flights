<?php


namespace Szrcai\Flights;


use Szrcai\Flights\Exception\PointsNotEnoughException;
use Szrcai\Flights\Exception\RouteNotFoundException;
use Szrcai\Flights\Models\Route;

class Traffic
{
    /**
     * Result
     * Return list of routes
     * @var array
     */
    private $routes = array();

    /**
     * Load data from json file
     * @param $dataPath
     * @throws \Exception
     */
    public function loadData($dataPath)
    {
        $data = (new Data($dataPath))->load();
        if ($data["routes"]) {
            foreach ($data["routes"] as $id => $route) {
                $newRoute = new Route($route["name"], $route["registration"]);
                $newRoute->setStartTime($route["start"])
                    ->setSpeed($route["speed"])
                    ->setNumber($id);
                if (count($route["tr"]) >= Route::MIN_POINTS) {
                    foreach ($route["tr"] as $point) {
                        $newRoute->addPoint($point[0], $point[1]);
                    }
                } else {
                    throw new PointsNotEnoughException("There must be at least " . Route::MIN_POINTS . " points. "
                        . "Missed " . (Route::MIN_POINTS - count($route["tr"])) . " points!");
                }
                $this->routes[$newRoute->number] = $newRoute;
            }
        }
    }

    /**
     * Add new route
     * @param Route $route
     * @throws PointsNotEnoughException
     */
    public function addRoute(Route $route)
    {
        $cntPoints = $route->getCountPoints();
        if ($cntPoints < Route::MIN_POINTS) {
            throw new PointsNotEnoughException("There must be at least " . Route::MIN_POINTS . " points. "
                . "Missed " . (Route::MIN_POINTS - $cntPoints) . " points!");
        }
        $this->routes[$route->number] = $route;
    }

    /**
     * Get lis of routes
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Return distance of the route in kilometers by number
     * @param $number
     * @return int
     * @throws RouteNotFoundException
     */
    public function distance($number)
    {
        return $this->getRoute($number)
            ->getDistance();
    }

    /**
     * Return estimated time of arrival by number
     * @param $number
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function timeArrival($number)
    {
        return $this->getRoute($number)
            ->finishTime();
    }

    /**
     * Return distance for each section of the route in kilometers for flight
     * @param $number
     * @param $leg
     * @return int
     * @throws RouteNotFoundException
     */
    public function partDistance($number, $leg)
    {
        return $this->getRoute($number)
            ->getPartDistance($leg);
    }

    /**
     * Return estimated time of arrival for each section of the route for flight
     * @param $number
     * @param $point
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function partTimeArrival($number, $point)
    {
        return $this->getRoute($number)
            ->partFinishTime($point);
    }

    /**
     * Return list of current airplanes that are already in flight but have not yet reached the final point
     * @param \DateTime|null $date
     * @return array
     * @throws \Exception
     */
    public function inAir(\DateTime $date = null)
    {
        $result = array();
        if (is_null($date)) {
            $date = new \DateTime();
        }

        foreach ($this->routes as $route) {
            $finishDate = new \DateTime($this->timeArrival($route->number));
            if ($finishDate > $date) {
                $result[] = $route;
            }
        }

        return $result;
    }

    /**
     * Return route by number
     * @param $number
     * @return mixed
     * @throws RouteNotFoundException
     */
    protected function getRoute($number)
    {
        if (isset($this->routes[$number])) {
            return $this->routes[$number];
        }

        throw new RouteNotFoundException("Route '$number' is not found!");
    }
}
