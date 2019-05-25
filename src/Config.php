<?php

namespace VinylStore;

class Config
{
    /** @var */
    protected $file;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return array|bool
     */
    public function parse()
    {
        $config = parse_ini_file($this->file, true);

        return $config;
    }
}