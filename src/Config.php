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
    protected $configFile;


    public function __construct($configFile)
    {
        $this->configFile = $configFile;
    }

    public function parse()
    {
        $config = parse_ini_file($this->configFile, true);
        return $config;
    }
}