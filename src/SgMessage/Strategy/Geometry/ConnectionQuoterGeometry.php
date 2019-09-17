<?php

class ConnectionQuoterGeometry
{
    /**
     * @param array $array
     * @return array
     */
    public function quoteArray(array $array): array
    {
        if (empty($array)) {
            return [];
        }
        foreach ($array as $key => $value) {
            $array[$key] = $this->quoteValue($value);
        }
        return $array;
    }

    /**
     * @param $value
     * @return string
     */
    public function quoteValue($value): string
    {
        if ($value === null) {
            return 'NULL';
        }
        return $value;
    }

    /**
     * @param string $identifier
     * @return string
     */
    public function quoteName(string $identifier): string
    {
        $identifier = trim($identifier);
        $separators = ['AS', ', ', ' ', '.'];

        foreach ($separators as $sep) {
            $pos = strripos($identifier, $sep);
            if ($pos) {
                return $this->quoteNameWithSeparator($identifier, $sep, $pos);
            }
        }
        return $this->quoteIdentifier($identifier);
    }

    /**
     * @param array $identifiers
     * @return array
     */
    public function quoteNames(array $identifiers): array
    {
        foreach ($identifiers as $key => $identifier) {
            $identifiers[$key] = $this->quoteName($identifier);
        }

        return $identifiers;
    }

    /**
     * @param string $spec
     * @param string $sep
     * @param int $pos
     * @return string
     */
    private function quoteNameWithSeparator(string $spec, string $sep, int $pos): string
    {
        $len = strlen($sep);
        $part1 = $this->quoteName(substr($spec, 0, $pos));
        $part2 = $this->quoteIdentifier(substr($spec, $pos + $len));
        return "{$part1}{$sep}{$part2}";
    }

    /**
     * @param string $name
     * @return string
     */
    public function quoteIdentifier(string $name): string
    {
        $name = trim($name);
        if ($name === '*') {
            return $name;
        }
        return '`' . str_replace('`', '``', $name) . '`';
    }
}
