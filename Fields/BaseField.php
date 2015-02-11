<?php
namespace PDFReport\Fields;

use PDFReport\General\Report;

// ToDo: Filter(s) for output formatting
abstract class BaseField {

	const DEFAULT_WIDTH = 150;

	/** @var array|null */
	protected $params = null;

	/**
	 * @param array $params
	 */
	public function __construct ( $params = array() ) {
		
		if ( !is_array( $params ) ) {
			$params = array();
		}
		
		$defaults =  array(
			'type'   => FieldTypes::MultiCell,
			'width'  => self::DEFAULT_WIDTH,
			'height' => 0,
			'border' => '',
			'ln'     => 0,
			'align'  => '',
			'fill'   => false
		);
		
		$this->params = array_merge( $defaults, $params );
	}

	/**
	 *
	 * @param Report $pdf
	 *
	 * @return string
	 */
	abstract public function get_output( $pdf );
	
	/**
	 * @return float Cell width. If 0, the cell extends up to the right margin.
	 */
	public function get_width() {
		return $this->params[ 'width' ]; 
	}

	/**
	 * @param float $width Cell width. If 0, the cell extends up to the right margin.
	 *
	 * @return $this
	 */
	public function set_width( $width ) {
		$this->params[ 'width' ] = $width;
		
		return $this;
	}

	/**
	 * @return float Cell height. Default value: 0.
	 */
	public function get_height() {
		return $this->params[ 'height' ];
	}

	/**
	 * @param float $height Cell height.
	 *
	 * @return $this
	 */
	public function set_height( $height ) {
		$this->params[ 'height' ] = $height;

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
	 * @return FieldTypes
	 */
	public function get_type() {
		return $this->params[ 'type' ];
	}

	/**
	 * @param string $type
	 *
	 * @return $this
	 */
	public function set_type( $type ) {
		$this->params[ 'type' ] = $type;
		
		return $this;
	}

	/**
	 * @return string
	 */
	public function get_value() {
		return $this->params[ 'value' ];
	}

	/**
	 * @param $value
	 *
	 * @internal param string $name
	 *
	 * @return $this
	 */
	public function set_value( $value ) {
		$this->params[ 'value' ] = $value;
		
		return $this;
	}

	/**
	 * @return mixed Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 */
	public function get_border() {
		return $this->params[ 'border' ];
	}

	/**
	 * @param mixed $border Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 *
	 * @return $this
	 */
	public function set_border( $border ) {
		$this->params[ 'border' ] = $border;
	
		return $this;
	}

	/**
	 * @return int Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul> Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 */
	public function get_ln() {
		return $this->params[ 'ln' ];
	}

	/**
	 * @param int $ln Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul> Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 *
	 * @return $this
	 */
	public function set_ln( $ln ) {
		$this->params[ 'ln' ] = $ln;
		
		return $this;
	}

	/**
	 * @return string Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 */
	public function get_align() {
		return $this->params[ 'align' ];
	}

	/**
	 * @param string $align Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 *
	 * @return $this
	 */
	public function set_align( $align ) {
		$this->params[ 'align' ] = $align;

		return $this;
	}

	/**
	 * @return boolean Indicates if the cell background must be painted (true) or transparent (false).
	 */
	public function get_fill() {
		return $this->params[ 'fill' ];
	}

	/**
	 * @param Boolean $fill Indicates if the cell background must be painted (true) or transparent (false).
	 *
	 * @return $this
	 */
	public function set_fill( $fill ) {
		$this->params[ 'fill' ] = $fill;
		
		return $this;
	}

	/**
	 * @param string $type
	 * @param mixed $raw_data
	 *
	 * @return int|string
	 */
	public static function format_field ( $type, $raw_data ) {

		if ( 'date' == $type ) {
			return date_i18n( 'm/d/y', strtotime( $raw_data ) );
		}
		elseif ( 'time' == $type ) {
			return date_i18n( 'g:i:s A', strtotime( $raw_data ) );
		}
		elseif ( 'datetime' == $type ) {
			return date_i18n( 'Y/m/d g:i:s A', strtotime( $raw_data ) );
		}
		elseif ( 'bool' == $type ) {
			return ( $raw_data == 1 ? 'Yes' : 'No' );
		}
		elseif ( 'number' == $type ) {
			return intval( $raw_data );
		}
		elseif ( 'decimal' == $type ) {
			return number_format( $raw_data, 2 );
		}

		return $raw_data;
	}

}