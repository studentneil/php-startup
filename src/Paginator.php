<?php

namespace VinylStore;

class Paginator
{
    /** @var int  */
    private $limit;

    /** @var int */
    private $offset;

    /** @var float  */
    private $numPages;

    /** @var int  */
    private $total;

    /** @var int */
    private $currentPage;

    /**
     * @param int $limit
     * @param int $total
     */
    public function __construct(int $limit, int $total)
    {
        $this->limit = $limit;
        $this->total = $total;
        $this->numPages = ceil($total / $limit);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        $this->offset = ($this->currentPage - 1) * $this->limit;

        return $this->offset;
    }

    /**
     * @param mixed $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return mixed
     */
    public function getNumPages()
    {
        return $this->numPages;
    }

    /**
     * @param mixed $numPages
     */
    public function setNumPages($numPages)
    {
        $this->numPages = $numPages;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = count($total);
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param string $currentPage
     */
    public function setCurrentPage(string $currentPage = '1')
    {
        $this->currentPage = (int) $currentPage;
    }
}
