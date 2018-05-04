<?php namespace Markard\GridData\Drivers\ResponseBuilder;


class DatatablesRawResponseBuilder extends ResponseBuilder
{

    /**
     * Return array representation of response
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'draw' => $this->getDraw(),
            'recordsTotal' => $this->repo->getTotal(),
            'recordsFiltered' => $this->repo->getFilteredTotal(),
            'data' => $this->repo->getData($this->sorts, $this->filters)
        ];
    }

    protected function getDraw()
    {
        if (!empty($this->rawInput)) {
            return $this->rawInput['draw'];
        }
    }
}