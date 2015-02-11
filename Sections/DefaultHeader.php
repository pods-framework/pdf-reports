<?php
namespace PDFReport\Sections;

use PDFReport\Fields\FieldTypes;
use PDFReport\General\FontSpec;
use PDFReport\Fields\TitleField;
use PDFReport\Fields\LineField;

class DefaultHeader extends BaseSection {

	/**
	 * @param array $params
	 */
	public function __construct ( $params = array() ) {

		parent::__construct( SectionNames::Header, $params );

		$title_params = array(
			'type'  => FieldTypes::Cell,
			'width' => 0,
			'ln'    => 1,
			'font'  => new FontSpec( array(
				'style' => 'B',
				'size'  => 16
			) )
		);
		
		$line_params = array(
			'type' => FieldTypes::Line,
		);
		
		$this
			->add_field( new TitleField( $title_params ) )
			->add_field( new LineField(  $line_params ) )
		;
	}

}
