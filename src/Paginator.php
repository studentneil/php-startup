<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 25/04/2017
 * Time: 23:24.
 */

namespace VinylStore;

class Paginator
{
    private $limit;
    private $offset;
    private $numPages;
    private $total;
    private $currentPage;

    public function __construct($limit, $total)
    {
        $this->limit = $limit;
        $this->total = $total;
        $this->numPages = ceil($total / $limit);
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
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
     * @param mixed $total
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
     * @param int $currentPage
     */
    public function setCurrentPage(int $currentPage = 1)
    {
        $this->currentPage = $currentPage;
    }
}
