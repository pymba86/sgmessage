<?php

namespace SgMessage;

/**
 * Интерфейс обьекта, в котором хранится уникальный индентификатор сообщения
 * @package SgMessage
 */
interface MessageInterface {

    /**
     * Вернуть индентификатор обьекта
     * @return int
     */
    function getId(): int;
}