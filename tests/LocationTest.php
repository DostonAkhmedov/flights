<?php


class LocationTest extends PHPUnit\Framework\TestCase
{
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $location = new Szrcai\Flights\Models\Location(56, 64);

        $this->assertInstanceOf('Szrcai\\Flights\\Models\\Location', $location);
        $this->assertIsInt($location->latitude);
        $this->assertIsInt($location->longitude);
        $this->assertGreaterThan(0, $location->latitude);
        $this->assertGreaterThan(0, $location->longitude);
    }
}