<?php
namespace PDFReport\General;

class FontSpec {

	/** @var array|null $params */
	protected $params = null;

	/**
	 * @param array $params
	 */
	public function __construct ( $params = array() ) {

		// Force array
		if ( !is_array( $params ) ) {
			$params = array();
		}

		$defaults = array(
			'family' => 'helvetica',
			'style'  => '',
			'size'   => 9,
			'color'  => array( 0, 0, 0 )
		);

		// Merge the defaults with the specified params
		$this->params = array_merge( $defaults, $params );
	}

	/**
	 * @return string
	 */
	public function get_family () {
		return $this->params[ 'family' ];
	}

	/**
	 * @param string $family
	 *
	 * @return $this
	 */
	public function set_family ( $family ) {
		$this->params[ 'family' ] = $family;

		return $this;
	}

	/**
	 * @return float
	 */
	public function get_size () {
		return $this->params[ 'size' ];
	}

	/**
	 * @param float $size
	 *
	 * @return $this
	 */
	public function set_size ( $size ) {
		$this->params[ 'size' ] = $size;

		return $this;
	}

	/**
	 * @return string
	 */
	public function get_style () {
		return $this->params[ 'style' ];
	}

	/**
	 * @param string $style
	 *
	 * @return $this
	 */
	public function set_style ( $style ) {
		$this->params[ 'style' ] = $style;

		return $this;
	}

	/**
	 * @return array R, G, B
	 */
	public function get_color () {
		return $this->params[ 'color' ];
	}

	/**
	 * @param array $color R, G, B values
	 *
	 * @return $this
	 */
	public function set_color ( $color ) {
		$this->params[ 'color' ] = $color;

		return $this;
	}

}
