<?php

namespace App\Domains;

use App\Contracts\Arrayable;

class Server extends Arrayable
{
    protected $model;
    protected $ram;
    protected $hdd;
    protected $location;
    protected $price;
    protected $compared;

    /**
     * @param $model
     * @param $ram
     * @param $hdd
     * @param $location
     * @param $price
     */
    public function __construct($model, $ram, $hdd, $location, $price)
    {
        $this->model = $model;
        $this->ram = $ram;
        $this->hdd = $hdd;
        $this->location = $location;
        $this->price = $price;
        $this->compared = false;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     * @return Server
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRam()
    {
        $matches = [];
        $ram = preg_match("/(.+)(GB)(.+)/", $this->ram, $matches) ? $matches : null;
        if($ram) {
            return [
                'amount' => (int) $ram[1],
                'unity' => $ram[2],
                'type' => $ram[3]
            ];
        }

        return null;
    }

    /**
     * @param mixed $ram
     * @return Server
     */
    public function setRam($ram)
    {
        $this->ram = $ram;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHdd()
    {
        $matches = [];
        $hdd = preg_match("/(.+)x(.+)(GB|TB)(.+)/", $this->hdd, $matches) ? $matches : null;
        if($hdd) {
            return [
                'amount' => $hdd[1] * $hdd[2],
                'unity' => $hdd[3],
                'type' => $hdd[4],
                'inGigabytes' => $hdd[3] === 'GB' ? $hdd[1] * $hdd[2] : $hdd[1] * $hdd[2] * 1000
            ];
        }

        return $this->hdd;
    }

    /**
     * @param mixed $hdd
     * @return Server
     */
    public function setHdd($hdd)
    {
        $this->hdd = $hdd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     * @return Server
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return Server
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
}
