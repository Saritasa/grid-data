<?php namespace Markard\GridData\Drivers;


use Markard\GridData\Drivers\ResponseBuilder\DatatablesEloquentResponseBuilder;
use Markard\GridData\Drivers\ResponseBuilder\DatatablesRawResponseBuilder;
use Markard\GridData\Drivers\ResponseBuilder\ResponseBuilder;
use Markard\GridData\EloquentRepository;
use Markard\GridData\Filter;
use Markard\GridData\GridDataRepositoryInterface;
use Markard\GridData\RawRepository;
use Markard\GridData\Sort;

class Datatables extends BaseDriver
{

    public function init(GridDataRepositoryInterface $repo, array $input = [])
    {
        $responseBuilder = $this->getResponseBuilder($repo);
        if (!empty($input)) {
            if (isset($input['order'])) {
                $responseBuilder->sort($this->getSorts($input));
            }
            if (isset($input['columns'])) {
                $responseBuilder->filter($this->getFilters($input));
            }
            if (isset($input['start']) && isset($input['length'])) {
                $responseBuilder->page($this->getPage($input));
                $responseBuilder->pageSize($this->getPageSize($input));
            }
        }

        return $responseBuilder;
    }

    protected function getSorts(array $input)
    {
        $result = [];

        foreach ($input['order'] as $order) {
            $result[] = new Sort($input['columns'][$order['column']]['data'], $order['dir']);
        }

        return $result;
    }

    protected function getFilters(array $input)
    {
        $result = [];

        foreach ($input['columns'] as $column) {
            $fieldName = !empty($column['name']) ? $column['name'] : $column['data'];
            if ($column['search']['value'] !== '') {
                $value = is_array($column['search']['value']) ? $column['search']['value']['value']
                    : $column['search']['value'];
                $result[] = new Filter($fieldName, $value);
            }
            if (!empty($input['search']['value']) && !empty($column['searchable'])) {
                $result[] = new Filter($fieldName, $input['search']['value']);
            }
        }

        return $result;
    }

    protected function getPage(array $input)
    {
        return (int)($input['start'] / $input['length']) + 1;
    }

    protected function getPageSize(array $input)
    {
        return $input['length'];
    }

    /**
     * @param GridDataRepositoryInterface $repo
     *
     * @return ResponseBuilder
     */
    protected function getResponseBuilder(GridDataRepositoryInterface $repo)
    {
        if ($repo instanceof EloquentRepository) {
            return new DatatablesEloquentResponseBuilder($repo);
        } else {
            if ($repo instanceof RawRepository) {
                return new DatatablesRawResponseBuilder($repo);
            }
        }
    }
}