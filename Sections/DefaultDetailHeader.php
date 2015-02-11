<?php
namespace PDFReport\Sections;

use PDFReport\General\Report;
use PDFReport\General\FontSpec;
use PDFReport\Fields\FieldTypes;
use PDFReport\Fields\StaticText;

class DefaultDetailHeader extends BaseSection {

	/**
	 * @param array $params
	 *
	 * @internal param WP_Admin_UI $admin
	 */
	public function __construct ( $params = array() ) {

		parent::__construct( SectionNames::DetailHeader, $params );

		// Font spec
		$this->set_font( new FontSpec( array(
			'family' => 'courier',
			'style'  => 'B',
		) ) );

	}

	/**
	 * @param Report $pdf
	 *
	 * @return BaseField[]
	 */
	public function get_fields( $pdf ) {
		static $first_run = true;

		if ( !$first_run ) {
			return $this->params[ 'fields' ];
		}

		$first_run = false;

		// Setup all the fields from the report info, iterate through the defined columns
		foreach ( $pdf->get_report_data()->get_columns() as $column_name => $column_data ) {

			// Ignore hidden fields
			if ( false === $column_data[ 'display' ] ) {
				continue;
			}

			// Cell alignment
			if ( $column_data[ 'type' ] === 'number' ) {
				$align = 'R';
			}
			else {
				$align = 'L';
			}

			$pdf_field = new StaticText( array(
				'type'  => FieldTypes::MultiCell,
				'value' => $column_data[ 'label' ], //--!! ToDo: tied to WP_Admin_UI implementation
				'align' => $align
			) );

			// Add field width if one was specified
			if ( !empty( $column_data[ 'width' ] ) ) {
				$pdf_field->set_width( (float) $column_data[ 'width' ] );
			}

			// Add this field
			$this->add_field( $pdf_field );
		}

		return $this->params[ 'fields' ];
	}
}
