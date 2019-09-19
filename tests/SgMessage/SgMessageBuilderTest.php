<?php

namespace Test\SgMessage;

use PHPUnit\Framework\TestCase;
use SgMessage\Geometry\Type\PointGeometry;
use SgMessage\SgMessageBuilder;
use SgMessage\Strategy\Geometry\Action\PointDistanceSphereGeometryAction;
use SgMessage\Strategy\Geometry\GeometryStrategy;

class SgMessageBuilderTest extends TestCase
{

    public function testCreateBuilder()
    {

        $point = new PointGeometry(1, 2);

        $connection = new DummyConnectionGeometry();
        $geometryStrategy = new GeometryStrategy($connection);
        $geometryStrategy
            ->table("messages")
            ->columns(["id", "name", "location"])
            ->primary("id")
            ->actions([
                    new PointDistanceSphereGeometryAction($point, "location", 1)
                ]
            );

        $builder = new SgMessageBuilder();
        $messages = $builder
            ->messages([])
            ->strategies([
                $geometryStrategy
            ]
        )->build();

        $this->assertEmpty($messages);
    }
}
