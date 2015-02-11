<?php
namespace PDFReport\Fields;

use PDFReport\General\Report;

class LineField extends BaseField {
	
	public function __construct( $params = array() ) {

		if ( !is_array( $params ) ) {
			$params = array();
		}

		$defaults =  array(
			'line_style' => array(
				'width' => 1,
				'cap'   => 'butt',
				'join'  => 'miter',
				'dash'  => 0,
				'color' => array( 0, 0, 0)
			)
		);
		
		$params = array_merge( $defaults, $params );

		parent::__construct( $params );
	}

	/**
	 * @param Report $pdf
	 *
	 * @return string
	 */
	public function get_output ( $pdf ) {
		return '';
	}

	/**
	 * @return array
	 */
	public function get_style() {
		return $this->params[ 'line_style' ];
	}

	/**
	 * @param array|null $line_style
	 *
	 * @return $this
	 */
	public function set_style( $line_style = array() ) {
		$this->params[ 'line_style' ] = $line_style;
		
		return $this;
	}
}
