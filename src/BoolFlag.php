<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 03/03/2017
 * Time: 23:33.
 */

namespace VinylStore;

class BoolFlag
{
    const IMAGE_UPLOAD_SUCCESS = 'Success! An image was uploaded';
    const IMAGE_UPLOAD_FAILURE = 'Sorry! No luck with that.';
    const IMAGE_ALREADY_EXISTS = 'Sorry, that image already exists.';
    const RELEASE_NOT_CREATED = 'Sorry, this release wasnt created';
    const RELEASE_CREATED = 'Success! A new release was created';
    const PRICING_ADDED = 'Success! Pricing data was added to a release';
    const PRICING_NOT_ADDED = 'Sorry, pricing data wasnt added';

    public function getImageSuccessMessage()
    {
        return self::IMAGE_UPLOAD_SUCCESS;
    }
    public function getFailureMessage()
    {
        return self::IMAGE_UPLOAD_FAILURE;
    }
    public function getImageAlreadyExists()
    {
        return self::IMAGE_ALREADY_EXISTS;
    }
    public function getReleaseNotCreated()
    {
        return self::RELEASE_NOT_CREATED;
    }
    public function getReleaseCreated()
    {
        return self::RELEASE_CREATED;
    }
    public function getPricingDataAdded()
    {
        return self::PRICING_ADDED;
    }
    public function getPricingNotAdded()
    {
        return self::PRICING_NOT_ADDED;
    }
}
