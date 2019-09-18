<?php

namespace Test\SgMessage;

use PHPUnit\Framework\TestCase;
use SgMessage\Geometry\Type\PointGeometry;
use SgMessage\SgMessageBuilder;
use SgMessage\Strategy\Geometry\Action\PointWithinGeometryAction;
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
            ->columns(["id", "name", "lat", "long"])
            ->primary("id")
            ->actions([
                    new PointWithinGeometryAction($point, 10, 3489)
                ]
            );

        $builder = new SgMessageBuilder();
        $messages = $builder->strategies([
                $geometryStrategy
            ]
        )
            ->messages([])
            ->build();

        $this->assertEmpty($messages);
    }
}
