<?php namespace Markard\GridData\Drivers;

use Markard\GridData\Drivers\ResponseBuilder\ResponseBuilder;
use Markard\GridData\GridDataRepositoryInterface;

abstract class BaseDriver implements GridDataInterface
{

    /**
     * @param GridDataRepositoryInterface $repo
     *
     * @return ResponseBuilder
     */
    abstract protected function getResponseBuilder(GridDataRepositoryInterface $repo);

    /**
     * @param array $input
     *
     * @return array Array of \Markard\GridData\Sort instances
     */
    abstract protected function getSorts(array $input);

    /**
     * @param array $input
     *
     * @return array Array of \Markard\GridData\Filter instances
     */
    abstract protected function getFilters(array $input);

    /**
     * @param array $input
     *
     * @return int
     */
    abstract protected function getPageSize(array $input);

    /**
     * @param array $input
     *
     * @return int
     */
    abstract protected function getPage(array $input);
}