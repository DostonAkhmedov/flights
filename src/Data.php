<?php


namespace Szrcai\Flights;


class Data
{
    private static $instance = null;

    private $loadDir = "/data/";

    private $fileName = "routes.json";

    private $filePath = null;

    private $result = array();

    public function __construct()
    {
        $this->filePath = $this->loadDir . $this->fileName;
    }

    public static function load()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        try {
            $data = file_get_contents(self::$instance->filePath);
            self::$instance->result = json_decode($data, true);
        } catch (\Exception $e) {
            throw new("Error with load data: ".$e->getMessage());
        }

        return self::$instance->result;
    }
}
