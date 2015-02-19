<?php
namespace PDFReport\General;

use PDFReport\Sections\BaseSection;
use PDFReport\General\ReportSpecOptions;

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
			ReportSpecOptions::Title        => '',
			ReportSpecOptions::PageFormat   => 'LETTER',
			ReportSpecOptions::Orientation  => 'P',
			ReportSpecOptions::Unit         => 'pt',
			ReportSpecOptions::MarginTop    => 15,
			ReportSpecOptions::MarginRight  => 15,
			ReportSpecOptions::MarginBottom => 20,
			ReportSpecOptions::MarginLeft   => 15,
			ReportSpecOptions::HeaderMargin => 5,
			ReportSpecOptions::CellPadding  => 0,
			ReportSpecOptions::Font         => $default_report_font,
			ReportSpecOptions::Sections     => array()
		);

		$this->params = array_merge( $default_report_params, $params );
	}

	/**
	 * @return string The report title
	 */
	public function get_title() {
		return $this->params[ ReportSpecOptions::Title ];
	}

	/**
	 * @param string $title
	 *
	 * @return $this
	 */
	public function set_title( $title ) { 
		$this->params[ ReportSpecOptions::Title ] = $title;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function get_orientation() {
		return $this->params[ ReportSpecOptions::Orientation ];
	}

	/**
	 * @param string $orientation
	 *
	 * @return $this
	 */
	public function set_orientation( $orientation ) {
		$this->params[ ReportSpecOptions::Orientation ] = $orientation;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_page_format() {
		return $this->params[ ReportSpecOptions::PageFormat ];
	}

	/**
	 * @param string $format
	 *
	 * @return $this
	 */
	public function set_page_format( $format ) {
		$this->params[ ReportSpecOptions::PageFormat ] = $format;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_unit() {
		return $this->params[ ReportSpecOptions::Unit ];
	}

	/**
	 * @param string $unit
	 *
	 * @return $this
	 */
	public function set_unit( $unit ) {
		$this->params[ ReportSpecOptions::Unit ] = $unit;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_margin_top() {
		return $this->params[ ReportSpecOptions::MarginTop ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_margin_top( $margin ) {
		$this->params[ ReportSpecOptions::MarginTop ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_margin_right() {
		return $this->params[ ReportSpecOptions::MarginRight ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_margin_right( $margin ) {
		$this->params[ ReportSpecOptions::MarginRight ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_margin_bottom() {
		return $this->params[ ReportSpecOptions::MarginBottom ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_margin_bottom( $margin ) {
		$this->params[ ReportSpecOptions::MarginBottom ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_margin_left() {
		return $this->params[ ReportSpecOptions::MarginLeft ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_margin_left( $margin ) {
		$this->params[ ReportSpecOptions::MarginLeft ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_header_margin() {
		return $this->params[ ReportSpecOptions::HeaderMargin ];
	}

	/**
	 * @param float $margin
	 *
	 * @return $this
	 */
	public function set_header_margin( $margin ) {
		$this->params[ ReportSpecOptions::HeaderMargin ] = $margin;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_cellpadding() {
		return $this->params[ ReportSpecOptions::CellPadding ];
	}

	/**
	 * @param float $padding
	 *
	 * @return $this
	 */
	public function set_cellpadding( $padding ) {
		$this->params[ ReportSpecOptions::CellPadding ] = $padding;

		return $this;
	}

	/**
	 * @return FontSpec|null
	 */
	public function get_font() {

		if ( isset( $this->params[ ReportSpecOptions::Font ]) ) {
			return $this->params[ ReportSpecOptions::Font ];
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
		$this->params[ ReportSpecOptions::Font ] = $font;

		return $this;
	}

	/**
	 * @return BaseSection[]
	 */
	public function get_sections() {
		return $this->params[ ReportSpecOptions::Sections ];
	}

	/**
	 * @param string $name
	 *
	 * @return BaseSection|null
	 */
	public function get_section( $name ) {

		if ( isset( $this->params[ ReportSpecOptions::Sections ][ $name ] ) ) {
			return $this->params[ ReportSpecOptions::Sections ][ $name ];
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

		$this->params[ ReportSpecOptions::Sections ][ $section->name() ] = $section;
		
		return $this;
	}

}
