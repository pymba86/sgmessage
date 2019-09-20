<?php

namespace SgMessage\Strategy\Geometry\Action;

use SgMessage\Geometry\Type\PointGeometry;
use SgMessage\Strategy\Geometry\ConnectionConditionGeometry;
use SgMessage\Strategy\Geometry\GeometryStrategyActionInterface;
use SgMessage\Strategy\Geometry\RawExpConnectionGeometry as RawExp;

/**
 * Задание для стратегии по поиску ближайших точек на заданном расстоянии (в киллометрах) от начальной точки
 *
 * @package SgMessage\Strategy\Geometry\Action
 */
class PointDistanceSphereGeometryAction implements GeometryStrategyActionInterface
{

    /**
     * Начальная точка
     *
     * @var PointGeometry
     */
    private $point;

    /**
     * Максимальное расстояние до ближайщих точек
     *
     * @var float
     */
    private $distance;

    /**
     * Колонка в таблице
     *
     * @var string
     */
    private $column;

    /**
     * @var float
     */
    private $radius;

    /**
     * Задание по поиску ближайших точек(сообщений)
     *
     * @param PointGeometry $point
     * @param string $column
     * @param float $distance
     */
    public function __construct(PointGeometry $point, string $column, float $distance, float $radius)
    {
        $this->point = $point;
        $this->distance = $distance;
        $this->column = $column;
        $this->radius = $radius;
    }

    public function handle(ConnectionConditionGeometry $condition): void
    {
        /**
         * SELECT *
         * FROM messages
         * WHERE ST_Distance_Sphere(ST_GeomFromText('Point(61.015032 69.056268)'), location, 6373) <= 0.2;
         */

        $condition->where(new RawExp(
            "ST_Distance_Sphere(ST_GeomFromText('{$this->point->toWkt()}'), {$this->column}, {$this->radius}) <= {$this->distance}"
        ));
    }

}
