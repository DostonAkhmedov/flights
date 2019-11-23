# flights

Package for emulate planes traffic along predefined paths

## Installation

Use Composer to install this package:

```
composer.phar install szrcai/flights
```

## Usage

```php
//Composer autoload package files
require __DIR__ . '/vendor/autoload.php';

//Create new object of new `\Szrcai\Flights\Traffic`
$traffic = new \Szrcai\Flights\Traffic();

//Load data from json (example: /examples/data/routes.json)
$traffic->loadData("data/routes.json");

//Add new route
$route = new \Szrcai\Flights\Models\Route(
    "AirBus", //The name of plane
    "RB-0000" //Registration number
);
$route->setNumber("NEW") //Flight number
    ->setStartTime("2019-11-22 01:00") //Departure time
    ->setSpeed(356) //The speed of plane
    ->addPoint(56, 64) //Starting point
    ->addPoint(50, 48) //Intermediate point
    //There can be many intermediate points
    //...
    ->addPoint(45, 36); //End point

//Save route
$traffic->addRoute($route);

//Get distance of the route in kilometers for flight number 'FV6702'
print_r($traffic->distance("FV6702")); echo "\n";
//Get estimated time of arrival for flight number 'FV6702'
print_r($traffic->timeArrival("FV6702")); echo "\n";
//Get distance in kilometers for second section of the route for flight number 'FV6702'
print_r($traffic->partDistance("FV6702", 2)); echo "\n";
//Get estimated time of arrival for first section of the route for flight number 'FV6702'
print_r($traffic->partTimeArrival("FV6702", 1)); echo "\n";
//List of current airplanes that are already in flight but have not yet reached the final point
print_r($traffic->inAir()); echo "\n";
//Get a list of the routes
print_r($traffic->getRoutes());
```

## Running tests using Composer
```
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests
```

## Running tests using PHP Archive (PHAR)
```
./phpunit --bootstrap src/autoload.php tests
```