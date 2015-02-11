<?php
namespace PDFReport\Sections;

use PDFReport\Fields\FieldTypes;
use PDFReport\General\FontSpec;
use PDFReport\Fields\LineField;
use PDFReport\Fields\StaticText;
use PDFReport\Fields\PageField;
use PDFReport\Fields\PagesField;
use PDFReport\Fields\DateField;

class DefaultFooter extends BaseSection {

	/**
	 * @param array $params
	 */
	public function __construct ( $params = array() ) {
		
		parent::__construct( SectionNames::Footer, $params );
		
		$this->set_font( new FontSpec( array(
			'style' => 'I'
		) ) );
		
		$this
			->add_field( new LineField( array(
				'type' => FieldTypes::Line
			) ) )
			->add_field( new StaticText( array(
				'type'  => FieldTypes::Cell,
				'value' => 'Page '
			) ) )
			->add_field( new PageField( array(
				'type'  => FieldTypes::Cell,
			) ) )
			->add_field( new StaticText( array(
				'type'  => FieldTypes::Cell,
				'value' => ' of '
			) ) )
			->add_field( new PagesField( array(
				'type'  => FieldTypes::Cell,
			) ) )
			->add_field( new DateField( array(
				'type'   => FieldTypes::Cell,
				'width'  => 0,
				'align'  => 'R'
			) ) )
		;

	}

}