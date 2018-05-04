<?php namespace Markard\GridData;


use Markard\GridData\Exceptions\InvalidOrderException;

class Sort
{
    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';

    protected $field;
    protected $order;

    /**
     * @param $field
     * @param $order
     *
     * @throws \Markard\GridData\InvalidOrderException
     */
    public function __construct($field, $order)
    {
        $order = strtolower($order);
        $this->validateOrder($order);

        $this->field = $field;
        $this->order = $order;
    }

    /**
     * @param $order
     *
     * @throws \Markard\GridData\Exceptions\InvalidOrderException
     */
    private function validateOrder($order)
    {
        if ($order !== self::ORDER_ASC && $order !== self::ORDER_DESC) {
            throw new InvalidOrderException();
        }
    }

    public function getField()
    {
        return $this->field;
    }

    public function getOrder()
    {
        return $this->order;
    }
}