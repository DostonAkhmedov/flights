<?php


class TrafficTest extends PHPUnit\Framework\TestCase
{
    private $filePath = "tests/data/routes.json"; //testData file path

    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $traffic = new Szrcai\Flights\Traffic();

        $this->assertInstanceOf('Szrcai\\Flights\\Traffic', $traffic);
    }

    public function testLoadData()
    {
        $traffic = new Szrcai\Flights\Traffic();
        $traffic->loadData($this->filePath);

        $this->assertGreaterThan(0, count($traffic->getRoutes()));
    }

    public function testAddRoute()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setNumber("NEW")
        ->setStartTime("2019-11-22 11:00")
        ->setSpeed(356)
        ->addPoint(56, 64)
        ->addPoint(45, 36);

        $traffic = new Szrcai\Flights\Traffic();
        $traffic->addRoute($route);
        $this->assertEquals(1, count($traffic->getRoutes()));
    }

    public function testDistance()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setNumber("NEW")
            ->addPoint(56, 64)
            ->addPoint(45, 36);

        $traffic = new Szrcai\Flights\Traffic();
        $traffic->addRoute($route);
        $distance = $traffic->distance("NEW");

        $this->assertEquals(2304, ceil($distance));
    }

    public function testTimeArrival()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setNumber("NEW")
            ->setStartTime("2019-11-22 11:00")
            ->setSpeed(356)
            ->addPoint(56, 64)
            ->addPoint(45, 36);

        $traffic = new Szrcai\Flights\Traffic();
        $traffic->addRoute($route);
        $time = $traffic->timeArrival("NEW");

        $this->assertEquals("2019-11-22 17:28", $time);
    }

    public function testPartDistance()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setNumber("NEW")
            ->addPoint(56, 64)
            ->addPoint(50, 48)
            ->addPoint(45, 36);

        $traffic = new Szrcai\Flights\Traffic();
        $traffic->addRoute($route);
        $partDistance = $traffic->partDistance("NEW", 2);

        $this->assertEquals(1058, ceil($partDistance));
    }

    public function testPartTimeArrival()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setNumber("NEW")
            ->setStartTime("2019-11-22 11:00")
            ->setSpeed(356)
            ->addPoint(56, 64)
            ->addPoint(45, 36);

        $traffic = new Szrcai\Flights\Traffic();
        $traffic->addRoute($route);
        $partTimeArrival = $traffic->partTimeArrival("NEW", 1);

        $this->assertEquals("2019-11-22 17:28", $partTimeArrival);
    }

    public function testInAir()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setNumber("NEW")
            ->setStartTime("2019-11-22 11:00")
            ->setSpeed(356)
            ->addPoint(56, 64)
            ->addPoint(45, 36);

        $traffic = new Szrcai\Flights\Traffic();
        $traffic->addRoute($route);
        $inAir = $traffic->inAir(new DateTime("2019-11-22 15:00"));

        $this->assertEquals(1, count($inAir));
    }
}
