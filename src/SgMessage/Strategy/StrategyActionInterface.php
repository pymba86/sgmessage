<?php

namespace SgMessage\Strategy;

/**
 * Интерфейс обьекта в котором происходит основная логика вычисления одинаковый сообщений
 *
 * @package SgMessage\Strategy
 */
interface StrategyActionInterface {

    /**
     * Запустить задания по вычислению одинаковых сообщений
     *
     * @return int[] Список сообщений
     */
    public function action(): array;
}
