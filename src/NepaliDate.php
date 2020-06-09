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
	 * Get formatted date.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $date Date details.
	 * @param string $format Format.
	 * @return string Formatted date.
	 */
	public function get_formatted_date( $date, $format ) {
		$output = '';

		$find = array_keys( $date );

		$replace = array_values( $date );

		$output = str_replace( $find, $replace, $format );

		return $output;
	}

	/**
	 * Get date details.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $date Date.
	 * @param string $language Language.
	 * @return array Date details.
	 */
	public function get_date_details( $date, $language = 'en' ) {
		$output = array();

		// Year two digit.
		$year2 = substr( $date['year'], -2 );

		if ( 'np' === $language ) {
			$output['Y'] = $this->get_nepali_number( $date['year'] );
			$output['y'] = $this->get_nepali_number( $year2 );
			$output['j'] = $this->get_nepali_number( $date['day'] );
			$output['d'] = $this->get_nepali_number( $date['day'], true );
			$output['F'] = $this->get_month_text( $date['month'], $language );
			$output['n'] = $this->get_nepali_number( $date['month'] );
			$output['m'] = $this->get_nepali_number( $date['month'], true );
			$output['l'] = $this->get_nepali_day_text( $date['weekday'] );
			$output['D'] = $this->get_nepali_day_text( $date['weekday'], 'D' );
		} else {
			$output['Y'] = (string) $date['year'];
			$output['y'] = $year2;
			$output['j'] = (string) $date['day'];
			$output['d'] = str_pad( $date['day'], 2, '0', STR_PAD_LEFT );
			$output['F'] = $this->get_month_text( $date['month'], $language );
			$output['n'] = (string) $date['month'];
			$output['m'] = str_pad( $date['month'], 2, '0', STR_PAD_LEFT );
			$output['l'] = $this->get_english_day_text( $date['weekday'] );
			$output['D'] = $this->get_english_day_text( $date['weekday'], 'D' );
		}

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

	/**
	 * Get Nepali day text.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $day Day in number.
	 * @param string $format Format.
	 * @return string Week text.
	 */
	private function get_nepali_day_text( $day, $format = 'l' ) {
		$output = '';

		$details = $this->get_nepali_week_details();

		if ( isset( $details[ $day ][ $format ] ) ) {
			$output = $details[ $day ][ $format ];
		}

		return $output;
	}

	/**
	 * Get English day text.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $day Day in number.
	 * @param string $format Format.
	 * @return string Week text.
	 */
	private function get_english_day_text( $day, $format = 'l' ) {
		$output = '';

		$details = $this->get_english_week_details();

		if ( isset( $details[ $day ][ $format ] ) ) {
			$output = $details[ $day ][ $format ];
		}

		return $output;
	}

	/**
	 * Get month text.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $month Month in number.
	 * @param string $language Language.
	 * @return string Month text.
	 */
	private function get_month_text( $month, $language = 'en' ) {
		$output = '';

		$details = $this->get_nepali_month_details();

		if ( isset( $details[ $month ][ $language ] ) ) {
			$output = $details[ $month ][ $language ];
		}

		return $output;
	}

	/**
	 * Get month details.
	 *
	 * @since 1.0.0
	 *
	 * @return array Month details.
	 */
	private function get_nepali_month_details() {
		$output = array(
			'1'  => array(
				'en' => 'Baishakh',
				'np' => 'बैसाख',
			),
			'2'  => array(
				'en' => 'Jeth',
				'np' => 'जेठ',
			),
			'3'  => array(
				'en' => 'Ashar',
				'np' => 'असार',
			),
			'4'  => array(
				'en' => 'Shrawan',
				'np' => 'श्रावन',
			),
			'5'  => array(
				'en' => 'Bhadra',
				'np' => 'भाद्र',
			),
			'6'  => array(
				'en' => 'Ashoj',
				'np' => 'असोज',
			),
			'7'  => array(
				'en' => 'Kartik',
				'np' => 'कार्तिक',
			),
			'8'  => array(
				'en' => 'Mangshir',
				'np' => 'मंसिर',
			),
			'9'  => array(
				'en' => 'Poush',
				'np' => 'पुष',
			),
			'10' => array(
				'en' => 'Magh',
				'np' => 'माघ',
			),
			'11' => array(
				'en' => 'Falgun',
				'np' => 'फाल्गुण',
			),
			'12' => array(
				'en' => 'Chaitra',
				'np' => 'चैत्र',
			),
		);

		return $output;
	}

	/**
	 * Get Nepali week details.
	 *
	 * @since 1.0.0
	 *
	 * @return array Week details.
	 */
	private function get_nepali_week_details() {
		$output = array(
			'1' => array(
				'l' => 'आइतबार',
				'D' => 'आइत',
			),
			'2' => array(
				'l' => 'सोमबार',
				'D' => 'सोम',
			),
			'3' => array(
				'l' => 'मंगलबार',
				'D' => 'मंगल',
			),
			'4' => array(
				'l' => 'बुधबार',
				'D' => 'बुध',
			),
			'5' => array(
				'l' => 'बिहिबार',
				'D' => 'बिहि',
			),
			'6' => array(
				'l' => 'शुक्रबार',
				'D' => 'शुक्र',
			),
			'7' => array(
				'l' => 'शनिबार',
				'D' => 'शनि',
			),
		);

		return $output;
	}

	/**
	 * Get English week details.
	 *
	 * @since 1.0.0
	 *
	 * @return array Week details.
	 */
	private function get_english_week_details() {
		$output = array(
			'1' => array(
				'l' => 'Aaitabar',
				'D' => 'Aaita',
			),
			'2' => array(
				'l' => 'Sombar',
				'D' => 'Som',
			),
			'3' => array(
				'l' => 'Mangalbar',
				'D' => 'Mangal',
			),
			'4' => array(
				'l' => 'Budhabar',
				'D' => 'Budha',
			),
			'5' => array(
				'l' => 'Bihibar',
				'D' => 'Bihi',
			),
			'6' => array(
				'l' => 'Sukhrabar',
				'D' => 'Sukhra',
			),
			'7' => array(
				'l' => 'Sanibar',
				'D' => 'Sani',
			),
		);

		return $output;
	}
}
