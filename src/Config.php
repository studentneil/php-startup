<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 07/06/2017
 * Time: 22:39
 */

namespace VinylStore;


class Config
{
    protected $file;


    public function __construct($file)
    {
        $this->file = $file;
    }

    public function parse()
    {
        $config = parse_ini_file($this->file, true);
        return $config;
    }
}