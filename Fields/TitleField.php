<?php
namespace PDFReport\Fields;

use PDFReport\General\Reportl;

class TitleField extends BaseField {

	/**
	 * @param Report $pdf
	 *
	 * @return string
	 */
	public function get_output ( $pdf ) {
		return $pdf->get_report_specs()->get_title();
	}
}
