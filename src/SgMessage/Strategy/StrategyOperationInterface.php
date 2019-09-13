<?php

namespace SgMessage\Strategy;

/**
 * Возможные варианты манипуляции с данными. Возможно регистрация нескольких операций
 * @package SgMessage\Strategy
 */
interface StrategyOperationInterface {

    /**
     * @param array $messages
     * @return mixed
     */
    public function next(array $messages);
}
