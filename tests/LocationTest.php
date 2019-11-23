<?php


class LocationTest extends PHPUnit\Framework\TestCase
{
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $location = new Szrcai\Flights\Models\Location(56, 64);

        $this->assertInstanceOf('Szrcai\\Flights\\Models\\Location', $location);
        $this->assertEquals(56, $location->latitude);
        $this->assertEquals(64, $location->longitude);
    }
}