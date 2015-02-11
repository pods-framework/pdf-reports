<?php
namespace PDFReport\Fields;

use PDFReport\General\Report;

class DateField extends BaseField {

	/**
	 * @param Report $pdf
	 *
	 * @return string
	 */
	public function get_output ( $pdf ) {
		return get_date_from_gmt( $pdf->get_creation_time(), 'm/d/Y H:i:s' );
	}
}
