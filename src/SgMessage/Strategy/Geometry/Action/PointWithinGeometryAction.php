<?php

namespace SgMessage\Strategy\Geometry\Action;

use SgMessage\Geometry\Type\Point;
use SgMessage\Strategy\StrategyActionInterface;

/**
 * Задание для стратегии по поиску ближайших точек на заданном расстоянии (в метрах) от начальной точки
 * 
 * @package SgMessage\Strategy\Geometry\Action
 */
class PointWithinGeometryAction implements StrategyActionInterface {

    /**
     * Начальная точка
     * 
     * @var Point
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
     * @param Point $point
     * @param int $distance
     */
    public function __construct(Point $point, int $distance)
    {
        $this->point = $point;
        $this->distance = $distance;
    }

    public function action(): array
    {
        /**
         * Добавляем к запросу условия
         */
    }


}