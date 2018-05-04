<?php namespace Markard\GridData;


class Filter
{

    protected $field;
    protected $value;

    /**
     * @param string $field
     * @param string $value
     *
     * @throws \Markard\GridData\InvalidOrderException
     */
    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getValue()
    {
        return $this->value;
    }

}