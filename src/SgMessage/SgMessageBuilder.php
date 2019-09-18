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
     *
     * @var int[]
     */
    protected $messages = [];

    /**
     * Список стратегий
     *
     * @var StrategyInterface[]
     */
    protected $strategies = [];

    /**
     * Список операций с сообщения
     *
     * @var StrategyOperationInterface[]
     */
    protected $operations = [];

    /**
     * Установить начальные идентификаторы сообщений, которые будут учтены в определении одинаковых
     *
     * @param int[] $messages
     * @return SgMessageBuilder
     */
    public function messages(array $messages): self
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
    public function strategies(array $strategies): self
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
    public function operations(array $operations): self
    {
        $this->operations = $operations;
        return $this;
    }

    /**
     * Запустить определение одинаковых сообщений
     *
     * @return array
     */
    public function build(): array
    {
        $messagesResult = $this->messages;

        foreach ($this->strategies as $strategy) {

            $messagesStrategy = $strategy->handle($messagesResult);

            if (!empty($messagesStrategy)) {
                $messagesResult = $messagesStrategy;
            } else {
                break;
            }
        }

        return $messagesResult;
    }
}
