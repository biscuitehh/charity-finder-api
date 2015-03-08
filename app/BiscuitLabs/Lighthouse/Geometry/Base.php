<?php
/**
 * Created by PhpStorm.
 * User: biscuit
 * Date: 3/7/15
 * Time: 3:27 AM
 */

namespace BiscuitLabs\Lighthouse\Geometry;


class Base {

    protected $srid;

    public function getSrid()
    {
        return $this->srid;
    }
}