<?php namespace Markard\GridData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Markard\GridData\Drivers\GridDataInterface;

abstract class EloquentRepository implements GridDataRepositoryInterface
{
    /**
     * Return model instance
     *
     * @return \Model
     */
    abstract public function getModel();

    /**
     * This method allows to prepare query for initial state.
     * For example you want to see table with only users with admin roles, you can do it here.
     *
     * @param Model $model
     *
     * @return mixed Should return \Illuminate\Database\Query\Builder or null.
     */
    public function hydrate(Model $model)
    {
        return $model->newQuery();
    }

    /**
     * Return combined fields for sorting.
     * Format should be like [
     *     'some_name' => ['field1', 'field2', ...]
     * ]
     *
     * @return array
     */
    public function getCombinedSortingFields()
    {
        return [];
    }

    /**
     * Return combined fields for filtering.
     * Format should be like [
     *     'some_name' => ['field1', 'field2', ...]
     * ]
     *
     * @return array
     */
    public function getCombinedFilteringFields()
    {
        return [];
    }

    /**
     * @param mixed $query Should return \Illuminate\Database\Query\Builder or \Eloquent class.
     * @param array $sorts Array of \Markard\GridData\Sort instances
     */
    public function sort($query, array $sorts)
    {
        if (!$sorts) {
            return;
        }

        $mapper = $this->getCombinedSortingFields();
        foreach ($sorts as $sort) {
            if (isset($mapper[$sort->getField()])) {
                foreach ($mapper[$sort->getField()] as $sortField) {
                    $query->orderBy($sortField, $sort->getOrder());
                }
            } else {
                $query->orderBy($sort->getField(), $sort->getOrder());
            }
        }
    }

    /**
     * @param mixed $query Should return \Illuminate\Database\Query\Builder or \Eloquent class.
     * @param array $filters Array of \Markard\GridData\Filter instances
     */
    public function filter($query, array $filters)
    {
        if (!$filters) {
            return;
        }

        $mapper = $this->getCombinedFilteringFields();
        $query->where(function ($query) use ($filters, $mapper) {
            foreach ($filters as $filter) {
                if (isset($mapper[$filter->getField()])) {
                    $mapperFields = $mapper[$filter->getField()];

                    $query->where(function ($query) use ($mapperFields, $filter) {
                        foreach ($mapperFields as $field) {
                            $query->orWhere($field, 'LIKE', '%' . $filter->getValue() . '%');
                        }
                    });

                } else {
                    $query->where($filter->getField(), 'LIKE', '%' . $filter->getValue() . '%');
                }
            }
        });
    }

    /**
     * This method allows to altering or totally change the resulting data.
     * This method returns the last result. There are no meta data.
     *
     * @param \Illuminate\Pagination\Paginator $paginator
     *
     * @internal param \Illuminate\Pagination\Paginator $result
     *
     * @return array
     */
    public function dehydrate(Paginator $paginator)
    {
        return $paginator->getCollection()->toArray();
    }
}