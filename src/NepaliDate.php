<?php
/**
 * Nepali Date class
 *
 * @author    Nilambar Sharma <nilambar@outlook.com>
 * @copyright 2020 Nilambar Sharma
 *
 * @package NepaliDate
 */

namespace ErNilambar\NepaliDate;

/**
 * NepaliDate class.
 *
 * @since 1.0.0
 */
class NepaliDate {

	/**
	 * NepaliCalendar object.
	 *
	 * @since 1.0.0
	 *
	 * @var NepaliCalendar
	 */
	protected $calendar;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->calendar = new NepaliCalendar();
	}

	/**
	 * Convert AD date to BS.
	 *
	 * @since 1.0.0
	 *
	 * @param int $y Year.
	 * @param int $m Month.
	 * @param int $d Day.
	 * @return array Converted date.
	 */
	public function ad_to_bs( $y, $m, $d ) {
		$output = array();

		$new_date = $this->calendar->eng_to_nep( $y, $m, $d );

		$output = $new_date;

		return $output;
	}

	/**
	 * Convert BS date to AD.
	 *
	 * @since 1.0.0
	 *
	 * @param int $y Year.
	 * @param int $m Month.
	 * @param int $d Day.
	 * @return array Converted date.
	 */
	public function bs_to_ad( $y, $m, $d ) {
		$output = array();

		$new_date = $this->calendar->nep_to_eng( $y, $m, $d );

		$output = $new_date;

		return $output;
	}

	/**
	 * Get Nepali number.
	 *
	 * @since 1.0.0
	 *
	 * @param int  $number Number.
	 * @param bool $padding Whether to do padding or not.
	 * @param int  $length Padding length.
	 * @return string Translated number.
	 */
	private function get_nepali_number( $number, $padding = false, $length = 2 ) {
		$new_numbers = array();

		$digits = array( '०', '१', '२', '३', '४', '५', '६', '७', '८', '९' );

		$num_arr = str_split( $number );

		$cnt = count( $num_arr );

		for ( $i = 0; $i < $cnt; $i++ ) {
			$new_numbers[ $i ] = $digits[ $num_arr[ $i ] ];
		}

		if ( true === $padding ) {
			$remaining = $length - $cnt;

			if ( $remaining > 0 ) {
				for ( $j = 0; $j < $remaining; $j++ ) {
					array_unshift( $new_numbers, $digits[0] );
				}
			}
		}

		return implode( '', $new_numbers );
	}
}
