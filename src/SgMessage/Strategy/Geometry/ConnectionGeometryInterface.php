<?php

namespace SgMessage\Strategy\Geometry;

use ConnectionQuoterGeometry;

/**
 * Интерфейс обьекта который делает запрос к базе данных
 *
 * @package SgMessage\Strategy\Geometry
 */
interface ConnectionGeometryInterface {

    public function query(string $q);

    public function getQuoter(): ConnectionQuoterGeometry;
}
