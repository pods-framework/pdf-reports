<?php
namespace PDFReport\General;

use PDFReport\Sections\BaseSection;

/**
 * Class ReportSpec
 */
class ReportSpec {

	/** @var array $params */
	protected $params;

	/**
	 * @param array $params
	 */
	public function __construct( $params = array() ) {

		// Force array
		if ( !is_array( $params ) ) {
			$params = array();
		}

		$default_report_font = new FontSpec( array(
			'family' => 'helvetica',
			'style'  => '',
			'size'   => 10,
			'color'  => array( 0, 0, 0 )
		) );

		// Default report specs
		$default_report_params = array(
			'title'         => '',
			'page_format'   => 'LETTER',
			'orientation'   => 'P',
			'unit'          => 'pt',
			'margin_top'    => 15,
			'margin_right'  => 15,
			'margin_bottom' => 20,
			'margin_left'   => 15,
			'header_margin' => 5,
			'cellpadding'   => 0,
			'font'          => $default_report_font,
			'sections'      => array()
		);

		$this->params = array_merge( $default_report_params, $params );
	}

	/**
	 * @return string The report title
	 */
	public function get_title() {
		return $this->params[ 'title' ];
	}

	/**
	 * @param string $title
	 *
	 * @return $this
	 */
	public function set_title( $title ) { 
		$this->params[ 'title' ] = $title;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function get_orientation() {
		return $this->params[ 'orientation' ];
	}

	/**
	 * @param string $orientation
	 *
	 * @return $this
	 */
	public function set_orientation( $orientation ) {
		$this->params[ 'orientation' ] = $orientation;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_page_format() {
		return $this->params[ 'page_format' ];
	}

	/**
	 * @param string $format
	 *
	 * @return $this
	 */
	public function set_page_format( $format ) {
		$this->params[ 'page_format' ] = $format;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_unit() {
		return $this->params[ 'unit' ];
	}

	/**
	 * @param string $unit
	 *
	 * @return $this
	 */
	public function set_unit( $unit ) {
		$this->params[ 'unit' ] = $unit;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_margin_top() {
		return $this->params[ 'margin_top' ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_margin_top( $margin ) {
		$this->params[ 'margin_top' ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_margin_right() {
		return $this->params[ 'margin_right' ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_margin_right( $margin ) {
		$this->params[ 'margin_right' ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_margin_bottom() {
		return $this->params[ 'margin_bottom' ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_margin_bottom( $margin ) {
		$this->params[ 'margin_bottom' ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_margin_left() {
		return $this->params[ 'margin_left' ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_margin_left( $margin ) {
		$this->params[ 'margin_left' ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_header_margin() {
		return $this->params[ 'header_margin' ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_header_margin( $margin ) {
		$this->params[ 'header_margin' ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_cellpadding() {
		return $this->params[ 'cellpadding' ];
	}

	/**
	 * @param float $padding
	 *
	 * @return $this
	 */
	public function set_cellpadding( $padding ) {
		$this->params[ 'cellpadding' ] = $padding;

		return $this;
	}

	/**
	 * @return FontSpec|null
	 */
	public function get_font() {

		if ( isset( $this->params[ 'font' ]) ) {
			return $this->params[ 'font' ];
		}
		else {
			return null;
		}

	}

	/**
	 * @param $font FontSpec
	 *
	 * @return $this
	 */
	public function set_font( $font ) {
		$this->params[ 'font' ] = $font;

		return $this;
	}

	/**
	 * @return BaseSection[]
	 */
	public function get_sections() {
		return $this->params[ 'sections' ];
	}

	/**
	 * @param string $name
	 *
	 * @return BaseSection|null
	 */
	public function get_section( $name ) {

		if ( isset( $this->params[ 'sections' ][ $name ] ) ) {
			return $this->params[ 'sections' ][ $name ];
		}
		else {
			return null;
		}
	}

	/**
	 * @param BaseSection $section
	 *
	 * @return $this
	 */
	public function add_section( $section ) {

		$this->params[ 'sections' ][ $section->name() ] = $section;
		
		return $this;
	}

}
