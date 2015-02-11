<?php
namespace PDFReport\Fields;

use PDFReport\General\Report;

class PagesField extends BaseField {

	/**
	 * @param Report $pdf
	 *
	 * @return string
	 */
	public function get_output ( $pdf ) {
		return (string) $pdf->getAliasNbPages();
	}
}
