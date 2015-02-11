<?php
namespace PDFReport\General;

use PDFReport\Data\BaseData;
use PDFReport\Fields\BaseField;
use PDFReport\Fields\LineField;
use PDFReport\Sections\BaseSection;
use PDFReport\Sections\SectionNames;

class Report extends \TCPDF {
	
	const ACTION_PREFIX = "pdfreport";

	// ToDo: This should be calculated
	const PAGE_BREAK_MARGIN = 50;
	
	/** @var ReportSpec|null */
	protected $report_specs = null;

	/** @var BaseData|null */
	protected $report_data = null;
	
	/** @var string|null */
	protected $export_file_path = null;
	
	/** @var FontSpec|null */
	protected $active_font = null;

	/** @var string|null */
	protected $creation_time = null;

	/**
	 * @param ReportSpec $report_specs
	 * @param BaseData $report_data
	 * @param string $export_file_path
	 *
	 * @internal param string $data
	 * @internal param string $report_spec JSON
	 */
	public function __construct( $report_specs, $report_data, $export_file_path ) {
	
		// Stash stuff and call the parent constructor; keep it short and sweet.  
		$this->set_report_specs( $report_specs );
		$this->set_report_data( $report_data );
		$this->export_file_path = $export_file_path;
		
		parent::__construct( $report_specs->get_orientation(), $report_specs->get_unit(), $report_specs->get_page_format() );
	}

	/**
	 *
	 */
	public function create_report () {
		
		do_action( self::ACTION_PREFIX . '_start_report', $this );

		$this->set_creation_time( date( 'Y-m-d H:i:s' ) );
		$this->initialize_pdf();

		// ToDo: This main detail loop is still dodgy
		$data_rows = $this->get_report_data()->get_data();
		foreach ( $data_rows as $this_row ) {

			$this->get_report_data()->set_row( $this_row );
			$this->render_section( SectionNames::Detail );
		}

		// Call Output and we're done
		$this->Output( $this->export_file_path, 'F' );

		do_action( self::ACTION_PREFIX . '_end_report', $this );
	}

	/**
	 * @return ReportSpec|null
	 */
	public function get_report_specs() {
		return $this->report_specs;
	}

	/**
	 * @param ReportSpec $report_specs
	 *
	 * @return $this
	 */
	public function set_report_specs( $report_specs ) {
		$this->report_specs = $report_specs;
		
		return $this;
	}

	/**
	 * @return BaseData
	 */
	public function get_report_data() {
		return $this->report_data;
	}

	/**
	 * @param BaseData $report_data
	 *
	 * @return $this
	 */
	public function set_report_data( $report_data ) {
		$this->report_data = $report_data;

		return $this;
	}

	/**
	 * @return null|FontSpec
	 */
	public function get_active_font() {
		return $this->active_font;
	}

	/**
	 * @param FontSpec $font_spec
	 *
	 * @return $this
	 */
	public function set_active_font( $font_spec ) {
		
		$this->active_font = $font_spec;

		$this->SetFont( $font_spec->get_family(), $font_spec->get_style(), $font_spec->get_size() );
		$this->SetTextColorArray( $font_spec->get_color() );
		
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function get_creation_time() {
		return $this->creation_time;
	}

	/**
	 * @param string $date_time
	 *
	 * @return $this
	 */
	public function set_creation_time( $date_time ) {
		$this->creation_time = $date_time;

		return $this;
	}

	/**
	 * 
	 */
	protected function initialize_pdf() {

		$spec = $this->get_report_specs();
		
		// Margins
		$this->SetMargins( $spec->get_margin_left(), $spec->get_margin_top(), $spec->get_margin_right() );
		$this->SetHeaderMargin( $spec->get_header_margin() );
		$this->SetFooterMargin( $spec->get_margin_bottom() );

		// Misc
		$this->SetAutoPageBreak( false );
		$this->SetCellPadding( $spec->get_cellpadding() );
		
		// Save this config as the default
		$this->default_graphic_vars = $this->getGraphicVars();

		$this->AddPage();
	}

	/**
	 * Overridden to call a start_page action hook
	 * 
	 * @param string $orientation
	 * @param string $format
	 * @param bool $tocpage
	 */
	public function startPage( $orientation='', $format='', $tocpage = false ) {

		// Call the parent method first to make sure page number is up to date when the action is called
		parent::startPage( $orientation, $format, $tocpage );

		do_action( self::ACTION_PREFIX . '_start_page', $this );
		
	}

	/**
	 * Overridden to call an end_page action hook
	 * 
	 * @param bool $tocpage
	 */
	public function endPage( $tocpage = false ) {
		
		parent::endPage( $tocpage );

		// endPage will be called on the first AddPage() call, before any pages have been rendered, so don't fire the 
		// end_page action hook unless we're ending an actual page
		if ( 0 != $this->page ) {
			do_action( self::ACTION_PREFIX . '_end_page', $this );	
		}
		
	}
		
	/**
	 * Overridden from TCPDF
	 *     - Removed code that moves the position around; just let things flow
	 *
	 * Add page if needed.
	 *
	 * @param $h (float) Cell height. Default value: 0.
	 * @param $y (mixed) starting y position, leave empty for current position.
	 * @param $addpage (boolean) if true add a page, otherwise only return the true/false state
	 *
	 * @return boolean true in case of page break, false otherwise.
	 * @since 3.2.000 (2008-07-01)
	 * @protected
	 */
	protected function checkPageBreak ( $h = 0, $y = '', $addpage = true ) {

		if ( \TCPDF_STATIC::empty_string( $y ) ) {
			$y = $this->y;
		}

		$current_page = $this->page;
		if ( ( ( (int) $y + (int) $h ) > $this->PageBreakTrigger ) AND ( $this->inPageBody() ) AND ( $this->AcceptPageBreak() ) ) {

			if ( $addpage ) {

				// Automatic page break
				$this->AddPage( $this->CurOrientation );
			}

			return true;
		}
		if ( $current_page != $this->page ) {

			// account for columns mode
			return true;
		}

		return false;
	}
	
	/**
	 * Overridden from TCPDF and stripped down some
	 */
	protected function setHeader() {

		// Nothing to do if there is no header section
		$sections = $this->get_report_specs()->get_sections();
		if ( !isset( $sections[ 'header' ] ) ) {
			return;
		}

		if ( !$this->print_header || ( $this->state != 2 ) ) {
			return;
		}
		
		$this->InHeader = true;
		
		$this->setGraphicVars( $this->default_graphic_vars );
		$lasth = $this->lasth;
		$newline = $this->newline;
		$this->_outSaveGraphicsState();
		$this->rMargin = $this->original_rMargin;
		$this->lMargin = $this->original_lMargin;

		//set current position
		if ( $this->rtl ) {
			$this->SetXY( $this->original_rMargin, $this->tMargin );
		}
		else {
			$this->SetXY( $this->original_lMargin, $this->tMargin );
		}
		
		$this->Header();
		
		$this->_outRestoreGraphicsState();
		$this->lasth = $lasth;
		$this->newline = $newline;
		$this->InHeader = false;
	}

	/**
	 * Overridden from TCPDF
	 */
	public function Header () {
		
		$this->render_section( SectionNames::Header );
		$this->Ln( $this->get_report_specs()->get_header_margin() );
		
		$this->render_section( SectionNames::DetailHeader );
	}

	/**
	 * Overridden from TCPDF
	 */
	public function Footer () {

		// Nothing to do if there is no footer section
		$footer_section = $this->get_report_specs()->get_section( 'footer' );
		if ( $footer_section === null ) {
			return;
		}
		
		$this->render_section( SectionNames::Footer );
	}

	/**
	 * Render a report section by name, if it exists.  
	 * Page breaks are currently managed here
	 * 
	 * @param string|BaseSection $section
	 */
	public function render_section( $section ) {

		// Section name was passed?  
		if ( is_string( $section ) ) { 		
			$section = $this->get_report_specs()->get_section( $section );
		}
 		
		// ToDo: error handling besides a silent exit? 
		if ( !is_object( $section ) || !( $section instanceof BaseSection ) ) {
			return;
		}

		// There is probably a cleaner way to go about this than pushing/restoring the y position
		$original_vertical_position = $this->GetY();
		$section->render( $this );
		$this->SetY( $original_vertical_position );

		// Move the vertical print position past the added section  
		$this->Ln( $section->get_height() );

		$this->SetAutoPageBreak( true, self::PAGE_BREAK_MARGIN );
		$this->checkPageBreak();
		$this->SetAutoPageBreak( false );
	}

	/**
	 * ToDo: Implement me
	 * 
	 * @param BaseField $field
	 *
	 * @return float The actual cell height for the rendered field (MultiCell heights can be variable)
	 */
	public function output_cell_clipped( $field ) {
		
		return $field->get_height();
	}

	/**
	 * @param BaseField $field
	 *
	 * @return float The actual cell height for the rendered field (MultiCell heights can be variable)
	 */
	public function output_cell( $field ) {

		$output = $field->get_output( $this );
		
		$width = ( 0 === $field->get_width() ) ? 0 : $this->GetStringWidth( $output );
		$field->set_width( $width );
		$field->set_height( $this->getStringHeight( $field->get_width(), $output ) );

		$this->Cell( $field->get_width(), $field->get_height(), $output, $field->get_border(), $field->get_ln(), $field->get_align(), $field->get_fill() );

		return $field->get_height();
	}

	/**
	 * @param BaseField $field
	 *
	 * @return float The actual cell height for the rendered field (MultiCell heights can be variable)
	 */
	public function output_multicell( $field ) {

		$output = $field->get_output( $this );

		$height = $this->getStringHeight( $field->get_width(), $output );

		$this->MultiCell( $field->get_width(), $height, $output, $field->get_border(), $field->get_align(), $field->get_fill(), $field->get_ln() );

		return $height;
	}

	/**
	 * @param BaseField|LineField $field
	 *
	 * @return float The rendered height
	 */
	public function output_line( $field ) {
		
		// ToDo: this is still prototyped; needs to be a more robust line drawing implementation 
		$x1 = $this->lMargin;
		$x2 = $this->w - $this->rMargin;
		$y1 = $y2 = $this->GetY();

		$this->Line( $x1, $y1, $x2, $y2, $field->get_style() );
		
		return abs( $y1 - $y2 );
	}

}