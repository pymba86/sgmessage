<?php

namespace SgMessage\Strategy\Geometry;

/**
 * Интерфейс обьекта который делает запрос к базе данных
 * 
 * @package SgMessage\Strategy\Geometry
 */
interface ConnectionGeometryStrategy {

    public function query(string $q);
}