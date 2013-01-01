<?php

class Cuztom_Field_Term_Select extends Cuztom_Field
{
	var $_supports_repeatable 	= true;
	
	var $dropdown;

	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );

		$this->options = array_merge(

			// Default
			array(
				'taxonomy'		=> 'category',
				'class'			=> ''
			),
			
			// Given
			$this->options

		);
		
		$this->options['class'] .= ' cuztom-input';
		$this->options['name'] 	= 'cuztom[' . $this->id_name . ']' . ( $this->repeatable ? '[]' : '' );
		$this->options['echo']	= 0;

		add_action( 'init', array( &$this, 'get_dropdown' ) );
	}

	function _output( $value )
	{
		$this->options['selected'] 	= ( ! empty( $value ) ? $value : $this->default_value );
		$output = $this->dropdown;

		return $output;
	}
	
	function _repeatable_output( $value )
	{
		$this->after = '[]';
		$output = '';

		if( is_array( $value ) )
		{
			foreach( $value as $item )
			{				
				$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>';
					$output .= $this->_output( $item );
				$output .= ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
			}
		}
		else
		{
			$output .= '<li class="cuztom-field cuztom-sortable-item js-cuztom-sortable-item"><div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>';
				$output .= $this->_output( $value );
			$output .= ( count( $value ) > 1 ? '<div class="js-cuztom-remove-sortable cuztom-remove-sortable"></div>' : '' ) . '</li>';
		}

		return $output;
	}

	/**
	 * Gets taxonomy terms for use in the output
	 * 
	 * @author 	Gijs Jorissen
	 * @since 	2.0
	 * 
	 */
	function get_dropdown()
    {
        $this->dropdown = wp_dropdown_categories( $this->options );
    }
}