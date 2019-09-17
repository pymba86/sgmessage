<?php

namespace SgMessage\Strategy\Geometry;

use ConnectionQuoterGeometry;
use SgMessage\Strategy\Exception\PrimaryColumnQueryException;

/**
 * Создает результирующий запрос к базе
 *
 * @package SgMessage\Strategy\Geometry
 */
class ConnectionQueryGeometry
{

    /**
     * @var ConnectionGeometryInterface
     */
    private $connection;

    /**
     * @var ConnectionQuoterGeometry
     */
    private $quoter;


    public function __construct(ConnectionGeometryInterface $connection)
    {
        $this->connection = $connection;
        $this->quoter = $connection->getQuoter();
    }

    /**
     * Получить запрос к базе
     *
     * @param array $query запрос
     * @param array $options дополнительные параметры
     * @return array запрос
     */
    public function getQuery(array $query, array $options = []): array
    {
        $query[] = trim('SELECT ' . trim(implode(' ', $options)));
        return $query;
    }

    /**
     * Получить запрос к базе с учетом колонки индетификатора сообщения
     *
     * @param array $query
     * @param string $column
     * @return array
     * @throws PrimaryColumnQueryException
     */
    public function getPrimaryColumn(array $query, string $column): array
    {
        if (empty($column)) {
            throw new PrimaryColumnQueryException("Error primary column not set");
        }

        $query[] = $this->quoter->quoteName($column);
        return $query;
    }

    /**
     * Получить запрос к базе с учетом колонок в таблице
     *
     * @param array $query
     * @param array $columns
     * @return array
     */
    public function getColumns(array $query, array $columns): array
    {
        if (empty($columns)) {
            $query[] = "*";
            return $query;
        }

        $result = [];

        foreach ($columns as $key => $column) {

            if (!is_int($key)) {
                $column = sprintf('%s AS %s', (string)$column, $key);
            }

            $result[] = $column;
        }

        $query[] = implode(',', $this->quoter->quoteNames($result));

        return $query;
    }

    /**
     * Получить запрос к базе с учетом таблицы
     *
     * @param array $query
     * @param string $from
     * @return array
     */
    public function getFrom(array $query, string $from): array
    {
        if (!empty($from)) {
            $query[] = 'FROM ' . $this->quoter->quoteName($from);
        }

        return $query;
    }

}
