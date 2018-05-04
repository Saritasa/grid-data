<?php namespace Markard\GridData;

use Illuminate\Support\Facades\App;
use Markard\GridData\Drivers\GridDataInterface;

abstract class RawRepository implements GridDataRepositoryInterface
{
    /**
     * Return model instance
     *
     * @param array $sorts Array of \Markard\GridData\Sort instances
     * @param array $filters Array of \Markard\GridData\Filter instances
     *
     * @return \Model
     */
    abstract public function getData(array $sorts, array $filters);

    /**
     * @return int
     */
    abstract public function getTotal();

    /**
     * @return int
     */
    abstract public function getFilteredTotal();

}