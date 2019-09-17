<?php

namespace SgMessage\Strategy\Geometry;

/**
 * Интерфейс обьекта в котором происходит добавление задания к запросу
 *
 * @package SgMessage\Strategy
 */
interface GeometryStrategyActionInterface
{

    /**
     * Добавление задания к запросу
     *
     * @param ConnectionConditionGeometry $condition
     * @return void
     */
    public function action(ConnectionConditionGeometry $condition): void;
}
