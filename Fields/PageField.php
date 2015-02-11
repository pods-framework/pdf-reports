<?php
namespace PDFReport\Fields;

use PDFReport\General\Report;

class PageField extends BaseField {

	/**
	 * @param Report $pdf
	 *
	 * @return string
	 */
	public function get_output ( $pdf ) {
		return trim( (string) $pdf->PageNo() );
	}
}
