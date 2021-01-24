<?php
declare(strict_types=1);

namespace App\Domain;

class Search
{
    private $catalogNumber;
    private $title;

    /**
     * @return mixed
     */
    public function getCatalogNumber()
    {
        return $this->catalogNumber;
    }

    /**
     * @param mixed $catalogNumber
     */
    public function setCatalogNumber(string $catalogNumber): void
    {
        $this->catalogNumber = $catalogNumber;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

}
