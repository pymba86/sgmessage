<?php

namespace SgMessage\Strategy\Geometry;

use SgMessage\Strategy\Exception\PrimaryColumnQueryException;
use SgMessage\Strategy\StrategyInterface;

/**
 * Стратегия обработки сообщений по их геоданным
 *
 * @package SgMessage\Strategy\Geometry
 */
class GeometryStrategy implements StrategyInterface
{

    /**
     * @var ConnectionGeometryInterface
     */
    protected $connection;

    /**
     * @var GeometryStrategyActionInterface[]
     */
    protected $actions;

    /**
     * @var string
     */
    protected $primaryColumn;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var ConnectionConditionGeometry
     */
    protected $condition;

    /**
     * Обработка сообщений по их геоданным
     *
     * @param ConnectionGeometryInterface $connection
     */
    public function __construct(ConnectionGeometryInterface $connection)
    {
        $this->connection = $connection;
        $this->condition = new ConnectionConditionGeometry($connection);
    }

    /**
     * Добавить задание в общий список
     *
     * @param GeometryStrategyActionInterface $action
     * @return GeometryStrategy
     */
    public function action(GeometryStrategyActionInterface $action): self
    {
        return $this;
    }

    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Установить таблицу по которой будет происходить поиск
     * @param string $table
     * @return GeometryStrategy
     */
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param string $column
     * @return GeometryStrategy
     */
    public function primary(string $column): self
    {
        $this->primaryColumn = $column;
        return $this;
    }

    /**
     * Создать запрос к базе
     *
     * @param bool $complete
     * @return string
     * @throws PrimaryColumnQueryException
     */
    protected function buildQuery(bool $complete = true): string
    {
        $builder = new ConnectionQueryGeometry($this->connection);

        $query = [];
        $query = $builder->getQuery($query);

        if (empty($this->columns)) {
            $query = $builder->getPrimaryColumn($query, $this->primaryColumn);
        } else {
            $query = $builder->getColumns($query, $this->columns);
        }

        $query = $builder->getFrom($query, $this->table);
        $query = $this->condition->getWhere($query);

        $result = trim(implode(' ', $query));

        if ($complete) {
            $result = trim($result) . ';';
        }

        return $result;
    }

    /**
     * @inheritdoc
     * @throws PrimaryColumnQueryException
     */
    public function handle(): array
    {
        // Создание sql запроса
        $query = $this->buildQuery(true);

        // Запрос к базе данных
        $this->connection->query($query);

        // Выборка id сообщений
    }


}
