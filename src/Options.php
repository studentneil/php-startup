<?php
declare(strict_types=1);

namespace VinylStore;

class Options
{
    /** @var array */
    private $choices = array();

    /** @var array*/
    private $mergedChoicesArray;

    /**
     * @param array $choices
     */
    public function __construct(array $choices)
    {
        $this->choices = $choices;
    }

    /**
     * @return array
     */
    public function mergeChoices()
    {
        foreach ($this->choices as $choice) {
            $id[] = $choice->getId();
            $title[] = $choice->getTitle();
        }
        $this->mergedChoicesArray = array_combine($title, $id);

        return $this->mergedChoicesArray;
    }
}
