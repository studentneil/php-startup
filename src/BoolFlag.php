<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 03/03/2017
 * Time: 23:33
 */

namespace VinylStore;


class BoolFlag
{
    const SUCCESS = 'Success!';
    const FAILURE = 'Sorry!';

    public function getSuccessMessage()
    {
        return self::SUCCESS;
    }
    public function getFailureMessage()
    {
        return self::FAILURE;
    }
}