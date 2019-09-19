<?php

namespace Test\SgMessage\Geometry\Type;

use PHPUnit\Framework\TestCase;
use SgMessage\Geometry\Type\PointGeometry;

class PointGeometryTest extends TestCase {


    /**
     * @throws \SgMessage\Geometry\Exception\GeoSpatialException
     */
    public function testPointDistance()
    {
        $p1 = new PointGeometry(61.015032,69.056268); // 1 общежитие
        $p2 = new PointGeometry(61.015144,69.057221); // 2 общежитие
        $vDistance = PointGeometry::distance($p1, $p2, "vincenty");
        $this->assertEquals(0, bccomp("52.838887149782", $vDistance));
        $hDistance = PointGeometry::distance($p1, $p2);
        $this->assertEquals(0, bccomp("52.838887149782", $hDistance));
    }


    public function testPointToWkt() {
        $p1 = new PointGeometry(61.015032,69.056268);
        $wktPoint = $p1->toWkt();

        $this->assertEquals('Point(61.015032 69.056268)', $wktPoint);
    }

}
