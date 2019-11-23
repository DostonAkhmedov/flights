<?php


class DataTest extends PHPUnit\Framework\TestCase
{

    private $filePath = "tests/data/routes.json"; //testData file path

    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $data = new Szrcai\Flights\Data($this->filePath);

        $this->assertInstanceOf('Szrcai\\Flights\\Data', $data);
    }

    public function testLoad()
    {
        $data = new Szrcai\Flights\Data($this->filePath);
        $loadData = $data->load();

        $this->assertGreaterThan(0, count($loadData));
    }
}