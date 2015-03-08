<?php
/**
 * Created by PhpStorm.
 * User: biscuit
 * Date: 3/7/15
 * Time: 4:38 AM
 */

namespace BiscuitLabs\Lighthouse\Geometry;


class Point extends Base {
    private $coordinates;

    public function __construct($dimension, Coordinates $coordinates = null, $srid = null)
    {
        $this->dimension = $dimension;
        $this->srid = $srid;
        $this->coordinates = $coordinates;
        $this->assert();
    }

    public function isEmpty()
    {
        return null === $this->coordinates;
    }

    public function getX()
    {
        if (null === $this->coordinates) {
            return null;
        }
        return $this->coordinates->getX();
    }

    public function getY()
    {
        if (null === $this->coordinates) {
            return null;
        }
        return $this->coordinates->getY();
    }

    public function getZ()
    {
        if (null === $this->coordinates) {
            return null;
        }
        return $this->coordinates->getZ();
    }

    public function getM()
    {
        if (null === $this->coordinates) {
            return null;
        }
        return $this->coordinates->getM();
    }
}