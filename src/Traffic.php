<?php


namespace Szrcai\Flights;


class Traffic
{
    private $routes = array();

    public function loadData()
    {
        $data = Data::load();
        print_r($data);
    }
}
