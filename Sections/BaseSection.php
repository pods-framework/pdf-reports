<?php
namespace PDFReport\Sections;

use PDFReport\Fields\FieldTypes;
use PDFReport\General\FontSpec;
use PDFReport\Fields\BaseField;
use PDFReport\General\Report;

abstract class BaseSection {

	/** @var string|null  */
	protected $name = null;
	
	/** @var array|null */
	protected $params = null;

	/**
	 * @param string $name Required: The name of the section
	 * @param array $params
	 */
	public function __construct ( $name, $params = array() ) {

		$this->name = $name;

		// Force array
		if ( !is_array( $params ) ) {
			$params = array();
		}

		$defaults = array(
			'fields' => array()
		);

		$this->params = array_merge( $defaults, $params );
	}

	/**
	 * @return null|string
	 */
	public function name() {
		return $this->name; 
	}

	/**
	 * @return float
	 */
	public function get_height () {
		return (float) $this->params[ 'height' ];
	}

	/**
	 * @param float $height
	 *
	 * @return $this
	 */
	public function set_height ( $height ) {
		$this->params[ 'height' ] = $height;

		return $this;
	}

	/**
	 * @return FontSpec|null
	 */
	public function get_font () {

		if ( isset( $this->params[ 'font' ] ) ) {
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
	public function set_font ( $font ) {
		$this->params[ 'font' ] = $font;

		return $this;
	}

	/**
	 * @param Report $pdf
	 *
	 * @return BaseField[]
	 */
	public function get_fields ( $pdf ) {

		return $this->params[ 'fields' ];
	}

	/**
	 * @param BaseField $field
	 *
	 * @return $this
	 */
	public function add_field ( $field ) {

		$this->params[ 'fields' ][ ] = $field;

		return $this;
	}

	/**
	 * @param Report $pdf
	 */
	public function render ( $pdf ) {

		// Use our defined font first, if we have one
		$section_font = ( null !== $this->get_font() ) ? $this->get_font() : $pdf->get_report_specs()->get_font();

		$total_height = 0;
		$row_height = 0;
		foreach ( $this->get_fields( $pdf ) as $this_field ) {

			// Does the field have a font specified? 
			if ( null !== $this_field->get_font() ) {

				// Use the field's font spec
				$font_spec = $this_field->get_font();
			}
			else {

				// Use the section or fallback font
				$font_spec = $section_font;
			}

			// ToDo: Wrappers are in place, removing direct TCPDF method dependencies, but this could certainly be better still 
			$pdf->set_active_font( $font_spec );
			$height = 0;
			switch ( $this_field->get_type() ) {

				case FieldTypes::Cell:
					$height = $pdf->output_cell( $this_field );
					break;

				case FieldTypes::Cell_Clipped:
					$height = $pdf->output_cell_clipped( $this_field );
					break;

				case FieldTypes::MultiCell:
					$height = $pdf->output_multicell( $this_field );
					break;

				case FieldTypes::Line:
					$height = $pdf->output_line( $this_field );
					break;

			}

			// Update max height for this row
			if ( $height > $row_height ) {
				$row_height = $height;
			}

			// Are we moving to a new line? 
			if ( 0 != $this_field->get_ln() ) {

				$total_height += $row_height;
				$row_height = 0;
			}
		}

		if ( 0 == $total_height ) {
			$total_height = $row_height;
		}

		$this->set_height( $total_height );
	}

}