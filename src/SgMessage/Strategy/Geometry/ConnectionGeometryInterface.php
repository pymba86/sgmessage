<?php

namespace SgMessage\Strategy\Geometry;

/**
 * Интерфейс обьекта который делает запрос к базе данных
 *
 * @package SgMessage\Strategy\Geometry
 */
interface ConnectionGeometryInterface
{
    /**
     * Возвращает массив обьектов(сообщений)
     *
     * @param string $q
     * @return array
     */
    public function query(string $q): array;

    public function getQuoter(): ConnectionQuoterGeometry;
}
