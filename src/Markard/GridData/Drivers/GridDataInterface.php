<?php namespace Markard\GridData\Drivers;


use Markard\GridData\GridDataRepositoryInterface;

interface GridDataInterface
{
    public function init(GridDataRepositoryInterface $repo, array $input);
}