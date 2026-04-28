<?php

namespace Nilambar\NepaliDate\Test;

use Nilambar\NepaliDate\NepaliDate;
use PHPUnit\Framework\TestCase;

/**
 * Add more regression checks by appending a row in {@see NepaliDateTest::knownAdBsPairProvider}:
 *   'short_label' => [ $adY, $adM, $adD, $bsY, $bsM, $bsD, $weekday ]
 * Weekday is the value returned by the library (1=Sunday .. 7=Saturday) and must match both
 * `convertAdToBs` and `convertBsToAd` for that calendar day.
 */
final class NepaliDateTest extends TestCase
{
    /**
     * Known AD (Gregorian) ↔ BS (Bikram Sambat) pairs, including weekday.
     * Keep labels short and unique; extend this list when you add new fixtures.
     *
     * @return \Generator<string, array{0:int,1:int,2:int,3:int,4:int,5:int,6:int}>
     */
    public static function knownAdBsPairProvider(): \Generator
    {
        yield '2020-01-01' => array(2020, 1, 1, 2076, 9, 16, 4);

        yield '1985-01-11' => array(1985, 1, 11, 2041, 9, 28, 6);

        yield '2020-04-13_2077-01-01' => array(2020, 4, 13, 2077, 1, 1, 2);

        yield '2020-02-29' => array(2020, 2, 29, 2076, 11, 17, 7);

        yield 'spearhead_1944-01-01' => array(1944, 1, 1, 2000, 9, 17, 7);

        yield 'last_ad_in_table' => array(2033, 4, 13, 2089, 12, 30, 4);

        yield 'sample_mid_2077_06' => array(2020, 10, 1, 2077, 6, 15, 5);
    }

    /**
     * @dataProvider knownAdBsPairProvider
     */
    public function testConvertAdToBsMatchesKnownPair(
        int $adY,
        int $adM,
        int $adD,
        int $bsY,
        int $bsM,
        int $bsD,
        int $weekday
    ): void {
        $obj = new NepaliDate();
        $new_date = $obj->convertAdToBs($adY, $adM, $adD);

        $this->assertSame($bsY, $new_date['year'], 'AD→BS year');
        $this->assertSame($bsM, $new_date['month'], 'AD→BS month');
        $this->assertSame($bsD, $new_date['day'], 'AD→BS day');
        $this->assertSame($weekday, $new_date['weekday'], 'AD→BS weekday');
    }

    /**
     * @dataProvider knownAdBsPairProvider
     */
    public function testConvertBsToAdMatchesKnownPair(
        int $adY,
        int $adM,
        int $adD,
        int $bsY,
        int $bsM,
        int $bsD,
        int $weekday
    ): void {
        $obj = new NepaliDate();
        $new_date = $obj->convertBsToAd($bsY, $bsM, $bsD);

        $this->assertSame($adY, $new_date['year'], 'BS→AD year');
        $this->assertSame($adM, $new_date['month'], 'BS→AD month');
        $this->assertSame($adD, $new_date['day'], 'BS→AD day');
        $this->assertSame($weekday, $new_date['weekday'], 'BS→AD weekday');
    }

    /**
     * @dataProvider knownAdBsPairProvider
     */
    public function testRoundTripAdToBsToAd(
        int $adY,
        int $adM,
        int $adD,
        int $bsY,
        int $bsM,
        int $bsD,
        int $weekday
    ): void {
        $obj = new NepaliDate();

        $bs = $obj->convertAdToBs($adY, $adM, $adD);
        $back = $obj->convertBsToAd($bs['year'], $bs['month'], $bs['day']);

        $this->assertSame($adY, $back['year']);
        $this->assertSame($adM, $back['month']);
        $this->assertSame($adD, $back['day']);
        $this->assertSame(
            array($bsY, $bsM, $bsD, $weekday),
            array($bs['year'], $bs['month'], $bs['day'], $bs['weekday'])
        );
    }

    /**
     * @dataProvider knownAdBsPairProvider
     */
    public function testRoundTripBsToAdToBs(
        int $adY,
        int $adM,
        int $adD,
        int $bsY,
        int $bsM,
        int $bsD,
        int $weekday
    ): void {
        $obj = new NepaliDate();

        $ad = $obj->convertBsToAd($bsY, $bsM, $bsD);
        $back = $obj->convertAdToBs($ad['year'], $ad['month'], $ad['day']);

        $this->assertSame($bsY, $back['year']);
        $this->assertSame($bsM, $back['month']);
        $this->assertSame($bsD, $back['day']);
        $this->assertSame(
            array($adY, $adM, $adD, $weekday),
            array($ad['year'], $ad['month'], $ad['day'], $ad['weekday'])
        );
    }

    /**
     * @dataProvider invalidEnglishDateProvider
     */
    public function testConvertAdToBsReturnsEmptyForInvalidDates($y, $m, $d): void
    {
        $obj = new NepaliDate();

        $this->assertSame(array(), $obj->convertAdToBs($y, $m, $d));
    }

    public function invalidEnglishDateProvider(): \Generator
    {
        yield 'before supported AD range' => array(1943, 12, 31);
        yield 'after supported AD range' => array(2034, 1, 1);
        yield 'day after last supported AD date' => array(2033, 4, 14);
        yield 'impossible february day' => array(2020, 2, 30);
    }

    /**
     * @dataProvider invalidBsDateProvider
     */
    public function testConvertBsToAdReturnsEmptyForInvalidDates($y, $m, $d): void
    {
        $obj = new NepaliDate();

        $this->assertSame(array(), $obj->convertBsToAd($y, $m, $d));
    }

    public function invalidBsDateProvider(): \Generator
    {
        yield 'before calendar start' => array(2000, 1, 1);
        yield 'after last BS day' => array(2090, 1, 1);
        yield 'day 31 in month with 30 days' => array(2089, 12, 31);
    }

    public function testGetDetailsBsEnglish(): void
    {
        $obj = new NepaliDate();

        $details = $obj->getDetails(2077, 1, 1, 'bs', 'en');

        $this->assertSame('2077', $details['Y']);
        $this->assertSame('77', $details['y']);
        $this->assertSame('01', $details['d']);
        $this->assertSame('Baishakh', $details['F']);
        $this->assertSame('Monday', $details['l']);
        $this->assertSame('Mon', $details['D']);
    }

    public function testGetDetailsBsNepali(): void
    {
        $obj = new NepaliDate();

        $details = $obj->getDetails(2077, 1, 1, 'bs', 'np');

        $this->assertSame('वैशाख', $details['F']);
        $this->assertSame('सोमबार', $details['l']);
        $this->assertSame('२०७७', $details['Y']);
    }

    public function testGetDetailsAdUsesConvertedBsDetails(): void
    {
        $obj = new NepaliDate();

        $details = $obj->getDetails(2020, 4, 13, 'ad', 'en');

        $this->assertSame('2077', $details['Y']);
        $this->assertSame('Baishakh', $details['F']);
    }

    public function testGetDetailsUnknownTypeReturnsEmptyArray(): void
    {
        $obj = new NepaliDate();

        $this->assertSame(array(), $obj->getDetails(2020, 1, 1, 'iso', 'en'));
    }

    public function testGetFormattedDateReplacesFormatTokens(): void
    {
        $obj = new NepaliDate();

        $out = $obj->getFormattedDate(
            array(
                'Y' => '2077',
                'm' => '01',
                'd' => '15',
            ),
            'Y-m-d'
        );

        $this->assertSame('2077-01-15', $out);
    }

    public function testValidateDateAcceptsValidBsDate(): void
    {
        $obj = new NepaliDate();

        $date = $obj->validateDate(2077, 1, 1, 'bs');

        $this->assertSame(2077, $date['year']);
        $this->assertSame(1, $date['month']);
        $this->assertSame(1, $date['day']);
    }

    public function testValidateDateRejectsOutOfRangeBsYear(): void
    {
        $obj = new NepaliDate();

        $this->assertSame(array(), $obj->validateDate(1999, 9, 17, 'bs'));
    }

    public function testValidateDateRejectsInvalidBsDayForMonth(): void
    {
        $obj = new NepaliDate();

        $this->assertSame(array(), $obj->validateDate(2089, 12, 31, 'bs'));
    }
}
