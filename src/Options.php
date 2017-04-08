<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 07/04/2017
 * Time: 23:21
 */

namespace VinylStore;


class Options
{
    private $choices = array();
    private $mergedChoicesArray;
    public function __construct(array $choices)
    {
        $this->choices = $choices;
    }

    /**
     * @param $choices
     * @return mixed
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