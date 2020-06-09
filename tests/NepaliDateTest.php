<?php

namespace Nilambar\NepaliDate\Test;

use Nilambar\NepaliDate\NepaliDate;
use PHPUnit\Framework\TestCase;

final class NepaliDateTest extends TestCase
{
    /**
     * Test AD to BS.
     */
    public function testAdToBs(): void
    {
        $obj = new NepaliDate();

        $src_date = array(
            'y' => '2020',
            'm' => '1',
            'd' => '1',
        );

        $new_date = $obj->convertAdToBs($src_date['y'], $src_date['m'], $src_date['d']);

        $this->assertEquals('2076', $new_date['year']);
        $this->assertEquals('9', $new_date['month']);
        $this->assertEquals('16', $new_date['day']);
        $this->assertEquals('4', $new_date['weekday']);
    }

    /**
     * Test BS to AD.
     */
    public function testBsToAd(): void
    {
        $obj = new NepaliDate();

        $src_date = array(
            'y' => '2077',
            'm' => '1',
            'd' => '1',
        );

        $new_date = $obj->convertBsToAd($src_date['y'], $src_date['m'], $src_date['d']);

        $this->assertEquals('2020', $new_date['year']);
        $this->assertEquals('4', $new_date['month']);
        $this->assertEquals('13', $new_date['day']);
        $this->assertEquals('2', $new_date['weekday']);
    }
}
