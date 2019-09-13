<?php

namespace SgMessage\Strategy;

/**
 * Интерфейс обьекта который делает запрос к базе данных
 *
 * @package SgMessage\Strategy\Geometry
 */
interface ConnectionStrategyInterface {

    public function query(string $q);
}
