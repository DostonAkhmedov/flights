<?php


namespace Szrcai\Flights;


class Data
{
    private $filePath;

    private $result = array();

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function load()
    {
        try {
            $data = file_get_contents($this->filePath);
            $this->result = json_decode($data, true);
        } catch (\Exception $e) {
            throw new \Exception("Error with load data: ".$e->getMessage());
        }

        return $this->result;
    }
}
