<?php
namespace PDFReport\Fields;

use PDFReport\General\Report;

class StaticText extends BaseField {

	/**
	 * @param Report $pdf
	 *
	 * @return string
	 */
	public function get_output( $pdf ) {
		return $this->get_value();
	}
}