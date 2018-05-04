<?php namespace Markard\GridData;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Manager;
use Markard\GridData\Drivers\Datatables;

class GridDataManager extends Manager
{
    public function createDatatablesDriver()
    {
        return new Datatables();
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return Config::get('GridData::grid-data.driver');
    }
}