<?php

namespace SgMessage\Strategy\Geometry;

use SgMessage\Strategy\StrategyActionInterface;
use SgMessage\Strategy\StrategyInterface;

class GeometryStrategy implements StrategyInterface {

    /**
     * @var ConnectionGeometryInterface
     */
    protected $connection;

    /**
     * @var StrategyActionInterface[]
     */
    protected $actions;
}