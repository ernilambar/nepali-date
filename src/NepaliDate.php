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

	protected $calendar;

	public function __construct() {
		$this->calendar = new NepaliCalendar();
	}

	public function ad_to_bs( $y, $m, $d ) {
		$output = array();

		$new_date = $this->calendar->eng_to_nep( $y, $m, $d );

		$output = $new_date;

		return $output;
	}

	public function bs_to_ad( $y, $m, $d ) {
		$output = array();

		$new_date = $this->calendar->nep_to_eng( $y, $m, $d );

		$output = $new_date;

		return $output;
	}

}
