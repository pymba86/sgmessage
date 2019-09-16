<?php

namespace SgMessage;

use SgMessage\Strategy\StrategyInterface;
use SgMessage\Strategy\StrategyOperationInterface;

/**
 * Class SgMessageBuilder
 *
 * Основной класс для настройки модуля поиска групповых сообщений
 *
 * @package SgMessage
 */
class SgMessageBuilder
{

    /**
     * Идентификаторы сообщений
     * @var int[]
     */
    public $messages;

    /**
     * Список стратегий
     * @var StrategyInterface[]
     */
    public $strategies;

    /**
     * Список операций с сообщения
     * @var StrategyOperationInterface[]
     */
    public $operations;

    /**
     * Установить начальные идентификаторы сообщений, которые будут учтены в определении одинаковых
     *
     * @param int[] $messages
     * @return SgMessageBuilder
     */
    public function messages(array $messages): SgMessageBuilder
    {
        $this->messages = array_unique($messages);
        return $this;
    }

    /**
     * Установить стратегии для поиска сообщений
     *
     * @param array $strategies
     * @return SgMessageBuilder
     */
    public function strategies(array $strategies): SgMessageBuilder
    {
        $this->strategies = $strategies;
        return $this;
    }

    /**
     * Установить операции для формирования результирующего списка сообщений
     * 
     * @param array $operations
     * @return SgMessageBuilder
     */
    public function operations(array $operations): SgMessageBuilder
    {
        $this->operations = $operations;
        return $this;
    }

    /**
     * Запустить определение одинаковых сообщений
     */
    public function run()
    {
        // Передача массива сообщений
        // Запуск стратегий
        // На каждом этапе стратегии пройтись по операциям 
        // Вернуть список сообщений
    }
}
