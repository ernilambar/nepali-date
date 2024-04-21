<?php

namespace Nilambar\NepaliDate\Test;

use Nilambar\NepaliDate\NepaliDate;
use PHPUnit\Framework\TestCase;

final class NepaliDateTest extends TestCase
{
    public function testAdToBs()
    {
        $obj = new NepaliDate();

        $src_date = array(
        'y' => 2020,
        'm' => 1,
        'd' => 1,
        );

        $new_date = $obj->convertAdToBs($src_date['y'], $src_date['m'], $src_date['d']);

        $this->assertSame(2076, $new_date['year']);
        $this->assertSame(9, $new_date['month']);
        $this->assertSame(16, $new_date['day']);
        $this->assertSame(4, $new_date['weekday']);
    }

    public function testOldAdToBs()
    {
        $obj = new NepaliDate();

        $src_date = array(
        'y' => 1985,
        'm' => 1,
        'd' => 11,
        );

        $new_date = $obj->convertAdToBs($src_date['y'], $src_date['m'], $src_date['d']);

        $this->assertSame(2041, $new_date['year']);
        $this->assertSame(9, $new_date['month']);
        $this->assertSame(28, $new_date['day']);
        $this->assertSame(6, $new_date['weekday']);
    }

    public function testBsToAd()
    {
        $obj = new NepaliDate();

        $src_date = array(
        'y' => 2077,
        'm' => 1,
        'd' => 1,
        );

        $new_date = $obj->convertBsToAd($src_date['y'], $src_date['m'], $src_date['d']);

        $this->assertSame(2020, $new_date['year']);
        $this->assertSame(4, $new_date['month']);
        $this->assertSame(13, $new_date['day']);
        $this->assertSame(2, $new_date['weekday']);
    }

    public function testOldBsToAd()
    {
        $obj = new NepaliDate();

        $src_date = array(
        'y' => 2041,
        'm' => 9,
        'd' => 28,
        );

        $new_date = $obj->convertBsToAd($src_date['y'], $src_date['m'], $src_date['d']);

        $this->assertSame(1985, $new_date['year']);
        $this->assertSame(1, $new_date['month']);
        $this->assertSame(11, $new_date['day']);
        $this->assertSame(6, $new_date['weekday']);
    }
}
