<?php


class RouteTest extends PHPUnit\Framework\TestCase
{
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );

        $this->assertInstanceOf('Szrcai\\Flights\\Models\\Route', $route);
        $this->assertEquals("AirBus", $route->name);
        $this->assertEquals("RB-0000", $route->registration);
    }

    public function testSetNumber()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setNumber("NEW");

        $this->assertEquals("NEW", $route->number);
    }

    public function testSetStartTime()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setStartTime("2019-11-22 11:00");

        $this->assertEquals("2019-11-22 11:00", $route->start);
    }

    public function testSetSpeed()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->setSpeed(350);

        $this->assertEquals(350, $route->speed);
    }

    public function testGetPoints()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->addPoint(56, 64)
            ->addPoint(45, 36);

        $points = $route->getPoints();
        $this->assertEquals(56, $points[0]->latitude);
        $this->assertEquals(64, $points[0]->longitude);
        $this->assertEquals(45, $points[1]->latitude);
        $this->assertEquals(36, $points[1]->longitude);
    }

    public function testGetCountPoints()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );

        $this->assertEquals(0, count($route->getPoints()));
    }

    public function testGetDistance()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->addPoint(56, 64)
            ->addPoint(45, 36);

        $this->assertEquals(2304, ceil($route->getDistance()));
    }

    public function testGetPartDistance()
    {
        $route = new Szrcai\Flights\Models\Route(
            "AirBus",
            "RB-0000"
        );
        $route->addPoint(56, 64)
            ->addPoint(50, 48)
            ->addPoint(45, 36);

        $this->assertEquals(1058, ceil($route->getPartDistance(2)));
    }

    public function testFinishTime()
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

        $this->assertEquals("2019-11-22 17:28", $route->finishTime());
    }

    public function testPartFinishTime()
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

        $this->assertEquals("2019-11-22 17:28", $route->partFinishTime(1));
    }
}
