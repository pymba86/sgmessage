<?php

namespace SgMessage\Geometry;

use CrEOF\Geo\WKT\Parser as WKTParser;
use CrEOF\Geo\WKB\Parser as WKBParser;

abstract class Object
{

    private static $types_map = [
        'POINT' => 'Point',
        "MULTIPOINT" => 'MultiPoint',
        'LINESTRING' => 'LineString',
        'MULTILINESTRING' => 'MultiLineString',
        'POLYGON' => 'Polygon',
        'MULTIPOLYGON' => 'GeometryCollection'
    ];

    private $wkt = null;
    private $wkb = null;
    protected $type = null;

    /**
     * Чтении данных из недоступных (защищенных или приватных) или несуществующих свойств
     *
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get(string $name)
    {
        if (strtolower($name) == 'wkt') {
            return ($this->wkt == null ? $this->wkt = $this->toWkt() : $this->wkt);
        } elseif (strtolower($name) == 'wkb') {
            return ($this->wkb == null ? $this->wkb = $this->toWkb() : $this->wkb);
        }

        return null;
    }

    /**
     * Вернуть класс обьекта по его названию типа
     *
     * @param string $type
     * @return string
     */
    private static function buildClassName(string $type)
    {
        return 'SgMessage\Geometry\Type\\' . self::$types_map[$type];
    }

    /**
     * Преобразовать обьект в массив
     *
     * @param $value
     * @return mixed
     */
    public static abstract function fromArray($value);

    /**
     * Преобразовать значение в массив
     * @return mixed
     */
    protected abstract function toValueArray();

    /**
     * Создать обьект по массиву параметров
     *
     * @param array $parsed
     * @return mixed
     */
    public static function buildObject(array $parsed)
    {
        /** @var Object $typeClass */
        $typeClass = self::buildClassName($parsed['type']);
        return $typeClass::fromArray($parsed['value']);
    }

    /**
     * Создать обьект по wkt значению
     *
     * @param $wkt
     * @return mixed
     */
    public static function fromWkt($wkt)
    {
        $parser = new WKTParser();
        $geo = self::buildObject($parser->parse($wkt));
        $geo->wkt = $wkt;
        return $geo;
    }

    /**
     * Преобразовать обьект в wkt значение
     *
     * @return string
     */
    public function toWkt()
    {
        return "$this->type($this)";
    }

    /**
     * Преобразовать обьект в wkb запись
     *
     * @throws \Exception
     */
    public function toWkb()
    {
        return null;
    }

    /**
     * Создать обьект по wkb значению
     *
     * @param $wkb
     * @return mixed
     */
    public static function fromWkb($wkb)
    {
        $parser = new WKBParser();
        $geo = self::buildObject($parser->parse($wkb));
        $geo->wkb = $wkb;
        return $geo;
    }

    /**
     * Преобразовать обьект в массив параметров
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'type' => $this->type,
            'value' => $this->toValueArray()
        ];
    }
}
