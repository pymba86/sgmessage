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
    public function message(array $messages): SgMessageBuilder
    {
        $this->messages = array_unique($messages);
        return $this;
    }

    /**
     * Запустить определение одинаковых сообщений
     */
    public function run()
    {
        // Запуск стратегий
    }
}
