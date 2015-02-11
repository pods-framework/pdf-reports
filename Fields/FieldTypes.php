<?php
namespace PDFReport\Fields;

abstract class FieldTypes {
	const Cell         = 'cell';
	const Cell_Clipped = 'cell_clipped';
	const MultiCell    = 'multicell';
	const Line         = 'line';
	const Page_Break   = 'page_break';
}