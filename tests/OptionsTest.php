<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 10/04/2017
 * Time: 21:09
 */

namespace VinylStoreTests;

use VinylStore\Options;
use VinylStore\Entity\ChoiceEntity;
use PHPUnit\Framework\TestCase;

class OptionsTest extends TestCase
{
    public function setUp()
    {
       $choice1 = new ChoiceEntity();
       $choice1->setId('1');
       $choice1->setTitle('copperhead road');
       $choice2 = new ChoiceEntity();
       $choice2->setId('2');
       $choice2->setTitle('suprema');
       $this->choices = array($choice1, $choice2);
       $this->merged = array('copperhead road' => '1'  , 'suprema' => '2' );

    }

    public function testOptionsArraysMerge()
    {
        $mergedOptions = new Options($this->choices);;
        $options = $mergedOptions->mergeChoices();
        $this->assertSame($this->merged, $options);
    }
}
