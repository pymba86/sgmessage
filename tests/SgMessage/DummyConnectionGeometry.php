<?php

namespace Test\SgMessage;


use SgMessage\Strategy\Geometry\ConnectionGeometryInterface;
use SgMessage\Strategy\Geometry\ConnectionQuoterGeometry;

class DummyConnectionGeometry implements ConnectionGeometryInterface
{
    /**
     * @var ConnectionQuoterGeometry
     */
    private $quoter;


    public function __construct()
    {
        $this->quoter = new ConnectionQuoterGeometry();
    }


    public function query(string $q): array
    {
       return [];
    }

    public function getQuoter(): ConnectionQuoterGeometry
    {
        return $this->quoter;
    }

}
