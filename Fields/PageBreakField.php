<?php
namespace PDFReport\Fields;

use PDFReport\General\Report;

class PageBreakField extends BaseField {

	public function __construct( $params = array() ) {

		if ( !is_array( $params ) ) {
			$params = array();
		}

		$defaults =  array(
			'type' => FieldTypes::Page_Break
		);

		$params = array_merge( $defaults, $params );

		parent::__construct( $params );
	}

	/**
	 *
	 * @param Report $pdf
	 *
	 * @return string
	 */
	public function get_output ( $pdf ) {

		// Don't page break if this is the last page
		// ToDo: not so hacky, please
		if ( $pdf->PageNo() < $pdf->get_report_data()->get_row_count() ) {
			
			// Returning the full height of a page will move us to the next page when the section height is calculated 
			return $pdf->getPageHeight();
		}
		else {

			return 0;
		}
	}
}
