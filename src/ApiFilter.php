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
     * Creates a new filter. Operator can be a COMP_ constant or a symbol (<, != etc).
     * Value2 is required for in (><), not in (<>) and between (&) operators.
     *
     * @param string $key
     * @param string $operator
     * @param mixed $value
     * @param mixed $value2
     * @return Schakel\WhiteWorks\ApiFilter
     */
    public static function factory($key, $operator, $value, $value2 = null)
    {
        $obj = new static();
        $obj->setKey($key);
        $obj->setFirstValue($value);

        switch ((string) $operator) {
            case self::COMP_IN:
            case '><':
                $obj->setOperator(self::COMP_IN);
                break;

            case self::COMP_NI:
            case '<>':
            case 'not in':
                $obj->setOperator(self::COMP_NI);
                break;

            case self::COMP_NE:
            case '!=':
            case 'not equal':
                $obj->setOperator(self::COMP_NE);
                break;

            case self::COMP_BT:
            case '&':
                $obj->setOperator(self::COMP_BT);
                break;

            case self::COMP_GE:
            case '>':
                $obj->setOperator(self::COMP_GE);
                break;

            case self::COMP_GT:
            case '>=':
                $obj->setOperator(self::COMP_GT);
                break;

            case self::COMP_LE:
            case '<':
                $obj->setOperator(self::COMP_LE);
                break;

            case self::COMP_LT:
            case '<=':
                $obj->setOperator(self::COMP_LT);
                break;

            case self::COMP_EQ:
            case '==':
            default:
                $obj->setOperator(self::COMP_EQ);
        }

        if ($obj->hasSecondValue()) {
            $obj->setSecondValue($val2);
        }
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
