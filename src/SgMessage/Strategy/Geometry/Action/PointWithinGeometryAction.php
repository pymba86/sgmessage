<?php

namespace SgMessage\Strategy\Geometry\Action;

use SgMessage\Geometry\Type\PointGeometry;
use SgMessage\Strategy\Geometry\ConnectionConditionGeometry;
use SgMessage\Strategy\Geometry\GeometryStrategyActionInterface;

/**
 * Задание для стратегии по поиску ближайших точек на заданном расстоянии (в метрах) от начальной точки
 * 
 * @package SgMessage\Strategy\Geometry\Action
 */
class PointWithinGeometryAction implements GeometryStrategyActionInterface {

    /**
     * Начальная точка
     * 
     * @var PointGeometry
     */
    private $point;

    /**
     * SRID точек
     * 
     * @var int
     */
    private $srid;

    /**
     * Максимальное расстояние до ближайщих точек
     * 
     * @var int
     */
    private $distance;

    /**
     * Задание по поиску ближайших точек(сообщений)
     *
     * @param PointGeometry $point
     * @param int $distance
     * @param int $srid
     */
    public function __construct(PointGeometry $point, int $distance, int $srid)
    {
        $this->point = $point;
        $this->distance = $distance;
        $this->srid = $srid;
    }

    public function handle(ConnectionConditionGeometry $condition): void
    {
        /**
         * Добавляем к запросу условия
         */

        $condition->where("name", "=", "Moscow");
    }

}
