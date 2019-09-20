<?php

namespace SgMessage\Geometry\Type;

use SgMessage\Geometry\Exception\GeoSpatialException;
use SgMessage\Geometry\ObjectGeometry;

/**
 * Географический объект - Одномерная геометрия, представляемая последвательностью точек.
 *
 * - На всемирной карте объекты LineString могли бы представлять реки.
 * - В городской карте объекты LineString могли бы представлять любые проходы.
 *
 * @package SgMessage\Geometry\Type
 */
class LineStringGeometry extends ObjectGeometry implements \Countable
{

    protected $type = "LineString";

    /**
     * @var PointGeometry[]
     */
    public $points = [];


    /**
     * Гео обьект из последовательных точек
     * @param array $points
     * @throws GeoSpatialException
     */
    public function __construct(array $points)
    {
        if (sizeof($points) < 2) {
            throw new GeoSpatialException("LineString must be composed by at least 2 points");
        }

        $this->points = array_map(function ($p) {
            if (!$p instanceof PointGeometry)
                throw new GeoSpatialException("LineString must be composed with Point array only");
        }, $points);
    }

    /**
     * @inheritdoc
     * @throws GeoSpatialException
     */
    public static function fromArray($points)
    {
        $parsed_points = array_map(function ($p) {
            if (!is_array($p) or sizeof($p) != 2)
                throw new GeoSpatialException('Error array of array containing lat, lon expected.');
            return new PointGeometry($p[0], $p[1]);
        }, $points);
        return new static($parsed_points);
    }

    /**
     * @inheritdoc
     */
    protected function toValueArray()
    {
        return array_map(function (PointGeometry $point) {
            return $point->toArray();
        }, $this->points);
    }

    /**
     * Преобразовать обьект в строку
     * @return string
     */
    public function __toString()
    {
        return implode(",", array_map(function (PointGeometry $point) {
            return $point;
        }, $this->points));
    }

    /**
     * Получить количество точек в обьекте
     *
     * @return int
     */
    public function count()
    {
        return count($this->points);
    }


}
