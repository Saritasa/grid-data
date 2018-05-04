<?php namespace Markard\GridData\Drivers\ResponseBuilder;


use Illuminate\Support\Facades\Paginator;
use Markard\GridData\GridDataRepository;
use Markard\GridData\GridDataRepositoryInterface;

abstract class ResponseBuilder
{

    /**
     * @var \Markard\GridData\Drivers\ResponseBuilder\GridDataRepository
     */
    protected $repo;

    /**
     * For handling special cases with client js packages.
     * @var array
     */
    protected $rawInput = [];

    protected $filters = [];

    protected $sorts = [];

    protected $page = 1;

    protected $pageSize = 15;


    /**
     * @param \Markard\GridData\GridDataRepositoryInterface $repo
     * @param array $rawInput
     */
    public function __construct(GridDataRepositoryInterface $repo, array $rawInput = [])
    {
        $this->repo = $repo;
        $this->rawInput = $rawInput;
    }

    /**
     * Set filters
     *
     * @param array $filters Array of \Markard\GridData\Filter instances
     */
    public function filter(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Set sorts
     *
     * @param array $sorts Array of \Markard\GridData\Sort instances
     */
    public function sort(array $sorts)
    {
        $this->sorts = $sorts;
    }

    /**
     * Set current page number
     *
     * @param int $page
     */
    public function page($page)
    {
        $this->page = $page;
    }

    /**
     * Set page size
     *
     * @param $pageSize
     */
    public function pageSize($pageSize)
    {
        $this->pageSize = $pageSize;
    }

    /**
     * Return array representation of response
     *
     * @return array
     */
    abstract public function toArray();


    /**
     * Return json representation of response
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

}