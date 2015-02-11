<?php
namespace PDFReport\Fields;

use PDFReport\General\Report;

class ValueField extends BaseField {

	/**
	 * @param Report $pdf
	 *
	 * @return string
	 */
	public function get_output( $pdf ) {
		
		$field_name = $this->get_value();
		$row = $pdf->get_report_data()->get_row();
		$cols = $pdf->get_report_data()->get_columns();

		if ( !is_array( $row ) || !isset( $cols[ $field_name ] ) ) {

			// ToDo: Error handling
			return;
		}

		$column_data = $cols[ $field_name ];

		// Custom display function?
		// ToDo: this was originally tied very closely to the WP_Admin_UI class.  Another candidate for a filter
		$custom_display = $column_data[ 'custom_display' ];
		if ( false !== $custom_display && function_exists( $custom_display ) ) {
			$row[ $field_name ] = $custom_display( $row[ $field_name ], $row, $field_name, $column_data, null );
		}

		// ToDo: This does not feel very elegant
		$pdf->get_report_data()->set_row( $row );
		
		$output = $row[ $field_name ];

		// ToDo: This should be done via filter
		$output = trim( $this->format_field( $column_data[ 'type' ], $output ) );

		return $output;
	}
}