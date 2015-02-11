<?php
namespace PDFReport\Data;

class BaseData {

	/** @var \Traversable|array  */
	protected $columns = null;

	/** @var \Traversable|array */
	protected $data = null;

	/** @var array|null */
	protected $current_row = null;
	
	/**
	 * @param \Traversable|array $data
	 * @param \Traversable|array $columns
	 */
	public function __construct( $data, $columns ) {
		$this->set_data( $data );
		$this->set_columns( $columns );
	}

	/**
	 * @return \Traversable
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * @param \Traversable $data
	 *
	 * @return $this
	 */
	public function set_data( $data ) {
		$this->data = $data;
		
		return $this;
	}

	/**
	 * @return \Traversable
	 */
	public function get_columns() {
		return $this->columns;
	}

	/**
	 * @param \Traversable $columns
	 *
	 * @return $this
	 */
	public function set_columns( $columns ) {
		$this->columns = $columns;

		return $this;
	}
	
	public function get_row_count() {
		
		return count( $this->data );
	}
	
	/**
	 * @return array|null
	 */
	public function get_row() {
		return $this->current_row;
	}

	/**
	 * @param array $row_data
	 *
	 * @return $this
	 */
	public function set_row( $row_data ) {
		$this->current_row = $row_data;

		return $this;
	}

}