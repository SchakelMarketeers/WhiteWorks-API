<?php
/**
 * Part of Schakel Marketeers WhiteWorks API
 *
 * @license GPL-v3
 * @link https://github.com/SchakelMarketeers/WhiteWorks-API
 */

namespace Schakel\WhiteWorks;

/**
 * Provides an easier way to indicate filters, using normal constructs instead
 * of weird arrays.
 *
 * @author Roelof Roos <roelof@schakelmarketeers.nl>
 */
class ApiFilter
{

    /**
     * @var string In a set
     */
    const COMP_IN = 'in';
    /**
     * @var string Not in a set
     */
    const COMP_NI = 'notin';
    /**
     * @var string Equal to
     */
    const COMP_EQ = 'equals';
    /**
     * @var string Not equal to
     */
    const COMP_NE = 'notequals';
    /**
     * @var string Inbetween 2 values
     */
    const COMP_BT = 'between';
    /**
     * @var string Greater than or equal
     */
    const COMP_GE = 'greaterequals';
    /**
     * @var string Greater than
     */
    const COMP_GT = 'greater';
    /**
     * @var string Less than or equal
     */
    const COMP_LE = 'lessqueals';
    /**
     * @var string Less than
     */
    const COMP_LT = 'less';

    /**
     * @var string Regex used to match against organic filters
     */
    const FILTER_REGEX = '/^([\w\-]{2,}) ([<>]|[!=<>]{2}|(?:not ?)?in|between) (.+?)(?: \|\| (.+?))?$/';

    /**
     * Creates a filter from a comparison string. See /doc/filters.md
     *
     * @param string $filter
     * @return Schakel\WhiteWorks\ApiFilter|null
     */
    public static function fromString($filter)
    {
        if (!preg_match(self::FILTER_REGEX, $filter, $matches)) {
            return null;
        }

        array_shift($matches);
        $obj->setKey(array_shift($matches));

        switch (array_shift($matches)) {
            case '><':
            case 'in':
                $obj->setOperator(self::COMP_IN);
                break;

            case '<>':
            case 'notin':
            case 'not in':
                $obj->setOperator(self::COMP_NI);
                break;

            case '!=':
                $obj->setOperator(self::COMP_NE);
                break;

            case 'between':
                $obj->setOperator(self::COMP_BT);
                break;

            case '>':
                $obj->setOperator(self::COMP_GE);
                break;

            case '>=':
                $obj->setOperator(self::COMP_GT);
                break;

            case '<':
                $obj->setOperator(self::COMP_LE);
                break;

            case '<=':
                $obj->setOperator(self::COMP_LT);
                break;

            case '==':
                $obj->setOperator(self::COMP_EQ);
                break;

            // Invalid key
            default:
                return null;
        }

        if ($obj->hasSecondValue() && count($matches) == 2) {
            $obj->setFirstValue(array_shift($matches));
            $obj->setSecondValue(array_shift($matches));
        } elseif ($obj->hasSecondValue()) {
            throw new \UnderflowException(sprintf(
                'Expected 2 arguments seperated by "||", received "%s".',
                $matches[0]
            ));
        } else {
            $obj->setFirstValue(implode(' || ', $matches));
        }
        return $obj;
    }


    /**
     * @var string $key
     */
    protected $key;

    /**
     * @var string $operator
     */
    protected $operator;

    /**
     * @var string $firstValue
     */
    protected $firstValue;

    /**
     * @var string $secondValue
     */
    protected $secondValue;

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return mixed
     */
    public function getFirstValue()
    {
        return $this->firstValue;
    }

    /**
     * @return mixed
     */
    public function getSecondValue()
    {
        return $this->secondValue;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = (string) $key;
    }

    /**
     * @param string $operator
     */
    public function setOperator($operator)
    {
        $this->operator = (string) $operator;
    }

    /**
     * @param string $value
     */
    public function setFirstValue($value)
    {
        $this->firstValue = $value;
    }

    /**
     * @param string $value
     */
    public function setSecondValue($value)
    {
        $this->secondValue = $value;
    }

    /**
     * Returns true if this operator has a second operator
     */
    public function hasSecondValue()
    {
        return in_array($this->getOperator, ['in', 'notin', 'between']);
    }

    /**
     * Returns an array for json_encode
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $out = [
            'field' => $this->getField(),
            'operator' => $this->getOperator(),
            'value' => $this->getFirstValue()
        ];
        if ($this->hasSecondValue()) {
            $out['value2'] = $this->getSecondValue();
        }

        return $out;
    }

}
