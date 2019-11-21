<?php

require_once __DIR__."/vendor/autoload.php";

$traffic = new \Szrcai\Flights\Traffic();

$traffic->loadData("data/routes.json");
$route = new \Szrcai\Flights\Models\Route("AirBus", "RB-0000");
$route->setNumber("NEW");
$route->setStartTime("2019-11-21 10:00");
$route->setSpeed(356);
$route->setPoint(56, 64);
$route->setPoint(45, 36);
$traffic->setRoute($route);
print_r($traffic->distance("FV6702"));
echo "\n";
print_r($traffic->timeArrival("FV6702"));
echo "\n";
print_r($traffic->partDistance("FV6702", 2));
echo "\n";
print_r($traffic->partTimeArrival("FV6702", 1));
echo "\n";
print_r($traffic->partTimeArrival("FV6702", 2));
echo "\n";
print_r($traffic->timeArrival("NEW"));
echo "\n";
print_r($traffic->inAir());
echo "\n";
print_r($traffic->getRoutes());