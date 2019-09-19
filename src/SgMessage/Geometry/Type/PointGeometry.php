<?php

namespace SgMessage\Geometry\Type;

use SgMessage\Geometry\Exception\GeoSpatialException;
use SgMessage\Geometry\ObjectGeometry;

class PointGeometry extends ObjectGeometry
{

    protected $type = "Point";

    protected static $greatCircleProviders = ['haversine', 'vincenty'];

    public $lat;

    public $lon;

    public $address;

    /**
     * Точка
     *
     * $point = new Point(1.123, 2.345)
     * $point = new Point("1.123", "2.2345")
     *
     * @param $lat
     * @param $lon
     */
    public function __construct($lat, $lon)
    {
        $this->lat = (float)$lat;
        $this->lon = (float)$lon;
    }

    /**
     * Преобразовать массив в обьект
     *
     * @param $points
     * @return mixed
     * @throws GeoSpatialException
     */
    public static function fromArray($points)
    {
        if (count($points) != 2) {
            throw new GeoSpatialException("Error wrong number of array elements, two needed");
        }

        return new PointGeometry($points[0], $points[1]);
    }

    /**
     * Преобразовать строку координат в обьект
     *
     * @param $points
     * @param string $separator
     * @throws GeoSpatialException
     */
    public static function fromString($points, $separator = " ")
    {
        $p = explode($separator, trim($points));

        if (count($p) != 2) {
            throw new GeoSpatialException("Error creating Point from string " . $points);
        }
    }

    /**
     * Преобразовать обьект в массив коориднат
     *
     * @return mixed
     */
    protected function toValueArray()
    {
        return [$this->lat, $this->lon];
    }

    /**
     * Преобразовать обьект в строку
     * @return string
     */
    public function __toString()
    {
        return "$this->lat $this->lon";
    }

    /**
     * Рассчитайте расстояние между двумя точками в метрах.
     *
     * @param PointGeometry $p1
     * @param PointGeometry $p2
     * @param string $provider
     * @return mixed
     * @throws GeoSpatialException
     */
    public static function distance(PointGeometry $p1, PointGeometry $p2, $provider = "haversine")
    {
        switch ($provider) {
            case "haversine":
                return self::haversineGreatCircleDistance($p1, $p2);
            case "vincenty":
                return self::vincentyGreatCircleDistance($p1, $p2);
            default:
                throw new GeoSpatialException('Great circle distance provider not found, providers available: '
                    . implode(", ", self::$greatCircleProviders));
        }
    }

    /**
     * @param PointGeometry $from
     * @param PointGeometry $to
     * @param int $earthRadius
     * @return float
     */
    private static function vincentyGreatCircleDistance(PointGeometry $from, PointGeometry $to, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($from->lat);
        $lonFrom = deg2rad($from->lon);
        $latTo = deg2rad($to->lat);
        $lonTo = deg2rad($to->lon);
        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    /**
     * @param PointGeometry $from
     * @param PointGeometry $to
     * @param int $earthRadius
     * @return float
     */
    private static function haversineGreatCircleDistance(PointGeometry $from, PointGeometry $to, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($from->lat);
        $lonFrom = deg2rad($from->lon);
        $latTo = deg2rad($to->lat);
        $lonTo = deg2rad($to->lon);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
}
