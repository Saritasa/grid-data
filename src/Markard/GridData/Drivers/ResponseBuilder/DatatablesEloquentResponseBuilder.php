<?php namespace Markard\GridData\Drivers\ResponseBuilder;


class DatatablesEloquentResponseBuilder extends ResponseBuilder
{

    /**
     * Return array representation of response
     *
     * @return array
     */
    public function toArray()
    {
        $model = $this->repo->getModel();

        $builder = $this->repo->hydrate($model);
        $this->repo->filter($builder, $this->filters);
        $this->repo->sort($builder, $this->sorts);

        \Paginator::setCurrentPage($this->page);
        $paginator = $builder->paginate($this->pageSize);

        return [
            'draw' => $this->getDraw(),
            'recordsTotal' => $paginator->getTotal(),
            'recordsFiltered' => $paginator->getTotal(),
            'data' => $this->repo->dehydrate($paginator)
        ];
    }

    protected function getDraw()
    {
        if (!empty($this->rawInput)) {
            return $this->rawInput['draw'];
        }
    }
}