<?php

namespace SgMessage\Strategy\Geometry;

use Closure;

class ConnectionConditionGeometry
{

    /**
     * @var \ConnectionQuoterGeometry
     */
    private $quoter;

    private $where = [];


    public function __construct(ConnectionGeometryInterface $connection)
    {
        $this->quoter = $connection->getQuoter();
    }

    public function getWhere(array $query): array
    {
        return $this->getCondition($query, $this->where, 'WHERE');
    }

    public function getCondition(array $query, array $where, string $conditionType): array
    {
        if (empty($where)) {
            return $query;
        }

        foreach ($where as $index => $item) {
            if ($item instanceof RawExpConnectionGeometry) {
                if ($index === 0) {
                    $sql[] = $conditionType . ' ' . $item->getValue();
                    continue;
                }
                $sql[] = $item->getValue();
                continue;
            }
            [$type, $conditions] = $item;
            if (!$index) {
                $whereType = $conditionType;
            } else {
                $whereType = strtoupper($type);
            }
            if ($conditions[0] instanceof RawExpConnectionGeometry) {
                $query[] = $whereType . ' ' . $conditions[0]->getValue();
                continue;
            }
            [$leftField, $operator, $rightField] = $conditions;
            $leftField = $this->quoter->quoteName($leftField);
            [$rightField, $operator] = $this->getRightFieldValue($rightField, $operator);
            $query[] = sprintf('%s %s %s %s', $whereType, $leftField, $operator, $rightField);
        }

        return $query;
    }

    private function getRightFieldValue($rightField, $comparison): array
    {
        if ($comparison === 'in' || $comparison === 'not in') {
            $rightField = '(' . implode(', ', $this->quoter->quoteArray((array)$rightField)) . ')';
        } elseif ($comparison === 'greatest' ||
            $comparison === 'least' ||
            $comparison === 'coalesce' ||
            $comparison === 'interval' ||
            $comparison === 'strcmp') {
            $comparison = '= ' . $comparison;
            $rightField = '(' . implode(', ', $this->quoter->quoteArray((array)$rightField)) . ')';
        } elseif ($comparison === '=' && $rightField === null) {
            $comparison = 'IS';
            $rightField = $this->quoter->quoteValue($rightField);
        } elseif (($comparison === '<>' || $comparison === '!=') && $rightField === null) {
            $comparison = 'IS NOT';
            $rightField = $this->quoter->quoteValue($rightField);
        } elseif ($comparison === 'between' || $comparison === 'not between') {
            $between1 = $this->quoter->quoteValue($rightField[0]);
            $between2 = $this->quoter->quoteValue($rightField[1]);
            $rightField = sprintf('%s AND %s', $between1, $between2);
        } elseif ($rightField instanceof RawExpConnectionGeometry) {
            $rightField = $rightField->getValue();
        } else {
            $rightField = $this->quoter->quoteValue($rightField);
        }
        return [$rightField, strtoupper($comparison)];
    }


    public function where(...$conditions): self
    {
        if ($conditions[0] instanceof Closure) {
            $this->addClauseCondClosure('where', 'AND', $conditions[0]);
            return $this;
        }
        $this->where[] = ['and', $conditions];
        return $this;
    }

    private function addClauseCondClosure(string $clause, string $andor, callable $closure): void
    {
        // retain the prior set of conditions, and temporarily reset the clause
        // for the closure to work with (otherwise there will be an extraneous
        // opening AND/OR keyword)
        $set = $this->$clause;
        $this->$clause = [];
        // invoke the closure, which will re-populate the $this->$clause
       //TODO $closure($this->query);
        // are there new clause elements?
        if (empty($this->$clause)) {
            // no: restore the old ones, and done
            $this->$clause = $set;
            return;
        }
        // append an opening parenthesis to the prior set of conditions,
        // with AND/OR as needed ...
        if ($set) {
            $set[] = new RawExpConnectionGeometry(strtoupper($andor) . ' (');
        } else {
            $set[] = new RawExpConnectionGeometry('(');
        }
        // append the new conditions to the set, with indenting
        $sql = [];
        $sql = $this->getCondition($sql, $this->$clause, '');
        foreach ($sql as $cond) {
            $set[] = new RawExpConnectionGeometry($cond);
        }
        $set[] = new RawExpConnectionGeometry(')');
        // ... then put the full set of conditions back into $this->$clause
        $this->$clause = $set;
    }


}
