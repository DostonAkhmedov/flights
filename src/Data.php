<?php


namespace Szrcai\Flights;


use Szrcai\Flights\Exception\FileNotFoundException;
use Szrcai\Flights\Exception\JsonDecodeException;

class Data
{
    /**
     * File path where the data is located
     * @var string
     */
    private $filePath;

    /**
     * Result
     * Return list of data
     * @var array
     */
    private $result = array();

    /**
     * Data constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Load data from json file
     * @return array|mixed
     * @throws FileNotFoundException
     * @throws JsonDecodeException
     */
    public function load()
    {
        if (!file_exists($this->filePath)) {
            throw new FileNotFoundException("File '{$this->filePath}' does not exist!");
        }
        $data = file_get_contents($this->filePath);
        $this->result = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonDecodeException("Error with data: ".json_last_error_msg());
        }


        return $this->result;
    }
}
