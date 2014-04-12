<?php

/**
 * Form validation library.
 *
 * @version 1.0.0
 * @author  Baghina Radu Adrian <support@webberty.com>
 * @see     https://github.com/webberty/Form-validation-library.git
 */
class WBB_Form_Validation
{

	/**
	 * Store Form Errors
	 *
	 * @var
	 */
	public $WBB_getErrors;


	/**
	 * Store all rules from multiple forms
	 *
	 * @var array
	 */
	protected $_WBB_getRules = array ();


	/**
	 * Store current form requested data
	 *
	 * @var array
	 */
	protected $_WBB_formSubmittedData = array ();

	/**
	 * Store current submitted form id
	 *
	 * @var
	 */
	protected $_WBB_submittedFormId = FALSE;


	/**
	 * Store current form requested files
	 *
	 * @var array
	 */
	protected $_WBB_formSubmittedFiles = array ();


	/**
	 * Default Errors Messages
	 *
	 * @var
	 */
	protected $WBB_default_error_messages = array (
		'required'                  => '%s is required. ' ,
		'required_file'             => '%s is required. ' ,
		'min_length'                => '%s must be at least %d characters or longer.' ,
		'max_length'                => '%s must be no longer than %d characters.' ,
		'str_between_length'        => '%s must be between min length %d and  max length %d.' ,
		'num_between_length'        => '%s must be between %d and length %d.' ,
		'valid_url'                 => '%s is an invalid url.' ,
		'real_url'                  => '%s must be a real url' ,
		'regex_match'               => '%s is an invalid data format.' ,
		'matches'                   => '%s must match %s .' ,
		'not_matches'               => '%s must not match with %s' ,
		'exact_length'              => '%s must be exactly %d characters in length.' ,
		'valid_email'               => '%s is an invalid email address.' ,
		'valid_ip'                  => '%s is an invalid IP format.' ,
		'alpha'                     => '%s is an invalid alpha format.' ,
		'alpha_numeric'             => '%s is an invalid alpha-numeric format.' ,
		'alpha_dash'                => '%s %s is an invalid alpha-dash format.' ,
		'numeric'                   => '%s is an invalid numeric format.' ,
		'is_numeric'                => '%s is not numeric.' ,
		'integer'                   => '%s must consist of integer value.' ,
		'decimal'                   => '%s must consist of decimal value.' ,
		'greater_than'              => '%s must be greater than %d .' ,
		'less_than'                 => '%s must be less than %d .' ,
		'is_natural'                => '%s is not natural.' ,
		'is_natural_no_zero'        => '%s is a Natural number, but not a zero  (1,2,3, etc.)' ,
		'valid_base64'              => '%s is invalid base 64 data' ,
		'word_limit'                => '%s must be no longer than %d words.' ,
		'ccnum'                     => '%s has to be a valid credit card number format' ,
		'between'                   => '%s must be number between %d and %d.' ,
		'valid_date'                => '%s must be a valid date' ,
		'allowed_file_types'        => '%s is invalid file type.' ,
		'one_of'                    => '%s has to be one of the allowed ones : %s' ,
		'valid_zip'                 => '%s is invalid ZIP format.' ,
		'start_with'                => '%s must start with %s' ,
		'not_start_with'            => '%s must not start with %s' ,
		'ends_with'                 => '%s must end with %s' ,
		'not_ends_with'             => '%s must not end with %s' ,
		'prep_url'                  => '' ,
		'encode_php_tags'           => '' ,
		'prep_for_form'             => '' ,
		'xss_clean'                 => '' ,
		''                          => '---------------TODO:---------------------------------' ,
		'min_date'                  => '%s must be a date lather then or equal to %s' ,
		'max_date'                  => '%s must be a date lather then or equal to %s' ,
		'callback'                  => '%s' ,
		'valid_emails'              => '%s has to be valid emails' ,
		'strip_image_tags'          => '' ,
		'strip_image_tagsxss_clean' => '' ,
		'sanitize_file_name'        => '' ,
		'slugify'                   => '' ,
		'valid_phone'               => '%s is invalid phone format number.' ,

	);

	//Utils Functions---------------------------------------------------------------------------------------------------

	/**
	 * Define values to validate.
	 * Set  Form Rules Array
	 *
	 * @param array $forms_rules
	 */
	public function WBB_setRules ( $forms_rules )
	{
		$this->_WBB_getRules = $forms_rules;
	}

	/**
	 * Add new rule to certain element
	 *
	 * @param $element
	 * @param $rule_array
	 * @param $submitted_form_id
	 */
	public function WBB_setRule ( $element , $rule_array , $submitted_form_id )
	{
		$current_element_rules                                            = $this->_WBB_getRules[ $submitted_form_id ][ $element ][ 'rules' ];
		$this->_WBB_getRules[ $submitted_form_id ][ $element ][ 'rules' ] = array_merge ( $current_element_rules , $rule_array );
	}

	/**
	 * Set Custom  Error Message
	 *
	 * @param $rule
	 * @param $error_msg
	 */
	public function WBB_setCustomErrorMessage ( $rule , $error_msg )
	{
		$this->WBB_default_error_messages[ $rule ] = $error_msg;
	}

	/**
	 * Get individual element error
	 *
	 * @param      $element_name
	 * @param      $submitted_form_id
	 * @param bool $show_label
	 *
	 * @return string
	 */
	public function WBB_getError ( $element_name , $submitted_form_id , $show_label = FALSE )
	{
		if ( $show_label )
		{
			$label_value = isset( $this->_WBB_getRules[ $submitted_form_id ][ $element_name ][ 'label' ] ) ? $this->_WBB_getRules[ $submitted_form_id ][ $element_name ][ 'label' ] : '';

			return isset( $this->WBB_getErrors[ $element_name ] ) == FALSE || empty( $this->WBB_getErrors[ $element_name ] ) ? $label_value : $this->WBB_getErrors[ $element_name ];

		}
		else
		{
			return $this->WBB_getErrors[ $element_name ];
		}

	}

	/**
	 * Run form validation
	 *
	 * @param $submit_form_id
	 *
	 * @return bool
	 */
	public function WBB_runForm ( $submit_form_id )
	{
		//Check if form was submitted
		if ( isset( $_REQUEST[ $submit_form_id ] ) )
		{

			//Store current submitted id
			$this->_WBB_submittedFormId = $submit_form_id;

			//Store current form requested data
			$this->_WBB_formSubmittedData = $_REQUEST;

			//Store current form requested files
			$this->_WBB_formSubmittedFiles = $_FILES;

			//Check for each form element their rules
			array_walk ( $this->_WBB_getRules[ $submit_form_id ] , array (
				$this ,
				'_executeForm'
			) );

			return empty( $this->WBB_getErrors );
		}

		return FALSE;
	}


	public function WBB_setErrorTextFormat ( $element_name , $rule_name , $vsprintf_data = array () )
	{
		$this->WBB_getErrors[ $element_name ] = vsprintf ( $this->WBB_default_error_messages[ $rule_name ] , $vsprintf_data );

	}

	//Core Class Functions----------------------------------------------------------------------------------------------

	/**
	 * Execute form validation process
	 *
	 * @param $element_value
	 * @param $element_name
	 */
	private function _executeForm ( $element_value , $element_name )
	{

		//If is not $_REQUEST then must be $_FILES
		$field_value = isset( $this->_WBB_formSubmittedData [ $element_name ] ) ? $this->_WBB_formSubmittedData [ $element_name ] : $this->_WBB_formSubmittedFiles [ $element_name ];
		$label       = isset( $element_value[ 'label' ] ) && ( ! empty( $element_value[ 'label' ] ) ) ? $element_value[ 'label' ] : FALSE;
		$rules       = $element_value[ 'rules' ];

		foreach ( $rules as $rule_name => $rule_value )
		{

			$rule_check_param = array (
				//Form element value .
				//OBS: $field_value can be also array in case we have $_FILES
				'field_value'  => $field_value ,
				//Form element name
				'element_name' => $element_name ,
				//Form element label
				'label'        => $label ,
				//Form element rule value
				'rule_value'   => $rule_value ,
				//Form element rule name
				'rule_name'    => $rule_name ,
			);

			//Apply callback rule to form element value
			call_user_func ( array (
				$this ,
				$rule_name
			) , $rule_check_param );
		}
	}

	//Default Form Validation Rules---------------------------------------------------------------------------------------------

	/**
	 * Required data works only for elements text, textarea
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */
	public function required ( $form_data = array () )
	{

		//Register a error if element rule didn't pass
		if ( empty( $form_data[ 'field_value' ] ) && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
		}
	}

	/**
	 * Required fiales works only for files elements
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */
	public function required_file ( $form_data = array () )
	{

		//Register a error if element rule didn't pass
		if ( empty( $form_data[ 'field_value' ][ 'name' ] ) && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
		}
	}

	/**
	 * Minimum Length
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */
	public function min_length ( $form_data = array () )
	{

		//Register a error if element rule didn't pass
		if ( strlen ( $form_data[ 'field_value' ] ) < $form_data[ 'rule_value' ] || preg_match ( "/[^0-9]/" , $form_data[ 'rule_value' ] ) && $form_data[ 'field_value' ] !== FALSE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
				$form_data[ 'label' ] ,
				$form_data[ 'rule_value' ]
			) );
		}
	}

	/**
	 * Maximum Length
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */
	public function max_length ( $form_data = array () )
	{
		//Register a error if element rule didn't pass
		if ( strlen ( $form_data[ 'field_value' ] ) > $form_data[ 'rule_value' ] || preg_match ( "/[^0-9]/" , $form_data[ 'rule_value' ] ) && $form_data[ 'field_value' ] !== FALSE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
				$form_data[ 'label' ] ,
				$form_data[ 'rule_value' ]
			) );
		}
	}

	/**
	 * String Between Length
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */
	public function str_between_length ( $form_data = array () )
	{

		//Register a error if element rule didn't pass
		$check = (bool) isset( $form_data[ 'rule_value' ][ 'min' ] ) && $form_data[ 'rule_value' ][ 'max' ] && ( ( mb_strlen ( $form_data[ 'field_value' ] ) >= $form_data[ 'rule_value' ][ 'min' ] && mb_strlen ( $form_data[ 'field_value' ] ) <= $form_data[ 'rule_value' ][ 'max' ] ) );
		if ( $check == FALSE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
				$form_data[ 'label' ] ,
				$form_data[ 'rule_value' ][ 'min' ] ,
				$form_data[ 'rule_value' ][ 'max' ]
			) );
		}
	}

	/**
	 * Number Between x, y
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */
	public function num_between_length ( $form_data = array () )
	{
		//Register a error if element rule didn't pass
		$check = isset( $form_data[ 'rule_value' ][ 'min' ] ) && isset( $form_data[ 'rule_value' ][ 'max' ] ) && $form_data[ 'field_value' ] >= $form_data[ 'rule_value' ][ 'min' ] && $form_data[ 'field_value' ] <= $form_data[ 'rule_value' ][ 'max' ];
		if ( $check == FALSE || preg_match ( '/^[\-+]?[0-9]*\.?[0-9]+$/' , $form_data[ 'field_value' ] ) == FALSE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
				$form_data[ 'label' ] ,
				$form_data[ 'rule_value' ][ 'min' ] ,
				$form_data[ 'rule_value' ][ 'max' ]
			) );
		}
	}


	/**
	 * Validate URL
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */
	public function valid_url ( $form_data = array () )
	{
		//Register a error if element rule didn't pass
		$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
		$check   = (bool) preg_match ( $pattern , $form_data[ 'field_value' ] );
		if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
		}
	}

	/**
	 *  Check for a real URL
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */

	public function real_url ( $form_data = array () )
	{
		//Register a error if element rule didn't pass
		$check = @fsockopen ( $form_data[ 'field_value' ] , 80 , $errno , $errstr , 30 );
		if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
		}

	}

	/**
	 * Performs a Regular Expression match test.
	 *
	 * @param array $form_data
	 *
	 * @return bool
	 */
	public function regex_match ( $form_data = array () )
	{
		//Register a error if element rule didn't pass
		$check = (bool) preg_match ( $form_data[ 'rule_value' ] , $form_data[ 'field_value' ] );
		if ( $check == FALSE )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
		}
	}

	/**
	 * Match one field to another/s
	 *
	 * @param array $form_data
	 */
	public function matches ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) ) //If Multiple elements added as array
		{
			if ( is_array ( $form_data[ 'rule_value' ] ) )
			{
				$get_not_match_labels = array ();
				foreach ( $form_data[ 'rule_value' ] as $check_matches )
				{
					if ( $form_data[ 'field_value' ] != $this->_WBB_formSubmittedData[ $check_matches ] )
					{
						$get_not_match_labels[ ] = $this->_WBB_getRules[ $this->_WBB_submittedFormId ][ $check_matches ][ 'label' ];
					}
				}

				if ( ! empty( $get_not_match_labels ) )
				{
					$string = implode ( ',' , $get_not_match_labels );
					//Register error
					$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
						$form_data[ 'label' ] ,
						$string
					) );
				}
			}
			//If one element check added as string
			else
			{
				if ( $form_data[ 'field_value' ] != $this->_WBB_formSubmittedData[ $form_data[ 'rule_value' ] ] )
				{
					//Register error
					$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
						$form_data[ 'label' ] ,
						$this->_WBB_getRules[ $this->_WBB_submittedFormId ][ $form_data[ 'rule_value' ] ][ 'label' ]
					) );
				}
			}
		}
	}

	/**
	 * Not match one field to another/s
	 *
	 * @param array $form_data
	 */
	public function not_matches ( $form_data = array () )
	{
		//If Multiple elements added as array
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			if ( is_array ( $form_data[ 'rule_value' ] ) )
			{
				$get_not_match_labels = array ();
				foreach ( $form_data[ 'rule_value' ] as $check_matches )
				{
					if ( $form_data[ 'field_value' ] == $this->_WBB_formSubmittedData[ $check_matches ] )
					{
						$get_not_match_labels[ ] = $this->_WBB_getRules[ $this->_WBB_submittedFormId ][ $check_matches ][ 'label' ];
					}
				}

				if ( ! empty( $get_not_match_labels ) )
				{
					$string = implode ( ',' , $get_not_match_labels );
					//Register error
					$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
						$form_data[ 'label' ] ,
						$string
					) );
				}
			}
			//If one element check added as string
			else
			{
				if ( $form_data[ 'field_value' ] == $this->_WBB_formSubmittedData[ $form_data[ 'rule_value' ] ] )
				{
					//Register error
					$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
						$form_data[ 'label' ] ,
						$this->_WBB_getRules[ $this->_WBB_submittedFormId ][ $form_data[ 'rule_value' ] ][ 'label' ]
					) );
				}
			}
		}
	}


	/**
	 * Exact Length
	 *
	 * @param array $form_data
	 */
	public function exact_length ( $form_data = array () )
	{
		if ( strlen ( $form_data[ 'field_value' ] ) != $form_data[ 'rule_value' ] || preg_match ( "/[^0-9]/" , $form_data[ 'rule_value' ] ) )
		{
			//Register error
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
				$form_data[ 'label' ] ,
				$form_data[ 'rule_value' ]
			) );
		}
	}


	/**
	 * Valid Email
	 *
	 * @param array $form_data
	 */
	public function valid_email ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = preg_match ( "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix" , $form_data[ 'field_value' ] );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Valid IP
	 *
	 * @param array $form_data
	 */
	public function valid_ip ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = filter_var ( $form_data[ 'field_value' ] , FILTER_VALIDATE_IP );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Valid Alpha
	 *
	 * @param array $form_data
	 */
	public function alpha ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = preg_match ( "/^([a-z])+$/i" , $form_data[ 'field_value' ] );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Valid Alpha-Numeric
	 *
	 * @param array $form_data
	 */
	public function alpha_numeric ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = preg_match ( "/^([a-z0-9])+$/i" , $form_data[ 'field_value' ] );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Valid Alpha-Dash
	 *
	 * @param array $form_data
	 */
	public function alpha_dash ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = preg_match ( "/^([-a-z0-9_-])+$/i" , $form_data[ 'field_value' ] );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Valid Numeric
	 *
	 * @param array $form_data
	 */
	public function numeric ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = preg_match ( "/^[\-+]?[0-9]*\.?[0-9]+$/" , $form_data[ 'field_value' ] );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Is Numeric ?
	 *
	 * @param array $form_data
	 */
	public function is_numeric ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = is_numeric ( $form_data[ 'field_value' ] );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Is Integer ?
	 *
	 * @param array $form_data
	 */
	public function integer ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = (bool) preg_match ( '/^[\-+]?[0-9]+$/' , $form_data[ 'field_value' ] );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Is Decimal ?
	 *
	 * @param array $form_data
	 */
	public function decimal ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			$check = (bool) preg_match ( '/^[\-+]?[0-9]+\.[0-9]+$/' , $form_data[ 'field_value' ] );
			if ( $check == FALSE && $form_data[ 'rule_value' ] === TRUE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}


	/**
	 *  Greater than
	 *
	 * @param array $form_data
	 */
	public function greater_than ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) && is_numeric ( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			if ( $form_data[ 'field_value' ] < $form_data[ 'rule_value' ] )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
					$form_data[ 'label' ] ,
					$form_data[ 'rule_value' ]
				) );
			}
		}
	}


	/**
	 *  Less than
	 *
	 * @param array $form_data
	 */
	public function less_than ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) && is_numeric ( $form_data[ 'field_value' ] ) )
		{
			//Register a error if element rule didn't pass
			if ( $form_data[ 'field_value' ] > $form_data[ 'rule_value' ] )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
					$form_data[ 'label' ] ,
					$form_data[ 'rule_value' ]
				) );
			}
		}
	}

	/**
	 * Is a Natural number  (0,1,2,3, etc.)
	 *
	 * @param array $form_data
	 */
	public function is_natural ( $form_data = array () )
	{

		if ( ! empty( $form_data[ 'field_value' ] ) && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register a error if element rule didn't pass
			$check = (bool) preg_match ( '/^[0-9]+$/' , $form_data[ 'field_value' ] );
			if ( $check == FALSE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}

	}

	/**
	 * Is a Natural number, but not a zero  (1,2,3, etc.)
	 *
	 * @param array $form_data
	 */
	public function is_natural_no_zero ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register a error if element rule didn't pass
			$check = (bool) preg_match ( '/^[0-9]+$/' , $form_data[ 'field_value' ] );
			if ( $check == FALSE || $form_data[ 'field_value' ] == 0 )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}

	}

	/**
	 * Valid Base64
	 * Tests a string for characters outside of the Base64 alphabet
	 * as defined by RFC 2045 http://www.faqs.org/rfcs/rfc2045
	 *
	 * @param array $form_data
	 */
	public function valid_base64 ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register a error if element rule didn't pass
			$check = (bool) preg_match ( '/[^a-zA-Z0-9\/\+=]/' , $form_data[ 'field_value' ] );
			if ( $check == FALSE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}

	}

	/**
	 * Field must be a valid credit card number format
	 * CC types: Visa,MasterCard, Discover , American Express,Diner's Club, JCB
	 *
	 * @param array $form_data
	 */
	public function ccnum ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register a error if element rule didn't pass
			$check = (bool) preg_match ( '/^(?:4\d{3}[ -]*\d{4}[ -]*\d{4}[ -]*\d(?:\d{3})?|5[1-5]\d{2}[ -]*\d{4}[ -]*\d{4}[ -]*\d{4}|6(?:011|5[0-9]{2})[ -]*\d{4}[ -]*\d{4}[ -]*\d{4}|3[47]\d{2}[ -]*\d{6}[ -]*\d{5}|3(?:0[0-5]|[68][0-9])\d[ -]*\d{6}[ -]*\d{4}|(?:2131|1800)[ -]*\d{6}[ -]*\d{5}|35\d{2}[ -]*\d{4}[ -]*\d{4}[ -]*\d{4})$/' , $form_data[ 'field_value' ] );
			if ( $check == FALSE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}

	}


	/**
	 * Field must be number between X and Y.
	 *
	 * @param array $form_data
	 */
	public function between ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			if ( is_array ( $form_data[ 'rule_value' ] ) )
			{
				$betwee_val = $form_data[ 'rule_value' ];
			}
			else
			{
				$betwee_val = explode ( ',' , $form_data[ 'rule_value' ] );
			}

			if ( in_array ( $form_data[ 'field_value' ] , call_user_func_array ( "range" , $betwee_val ) ) == FALSE || ! is_numeric ( $form_data[ 'field_value' ] ) )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
					$form_data[ 'label' ] ,
					$betwee_val[ 0 ] ,
					$betwee_val[ 1 ]
				) );
			}
		}
	}


	/**
	 * Check if string is one of the rule array or rule string ("val1, val2, val3") or array("val1","val2", "val3")
	 *
	 * @param array $form_data
	 */
	public function one_of ( $form_data = array () )
	{

		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			$allowed_ones   = is_array ( $form_data[ 'rule_value' ] ) ? implode ( ',' , $form_data[ 'rule_value' ] ) : $form_data[ 'rule_value' ];
			$check_if_is_in = is_array ( $form_data[ 'rule_value' ] ) ? $form_data[ 'rule_value' ] : explode ( ',' , $form_data[ 'rule_value' ] );

			if ( ! in_array ( $form_data[ 'field_value' ] , $check_if_is_in ) )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
					$form_data[ 'label' ] ,
					$allowed_ones ,
				) );
			}
		}

	}


	/**
	 * Field must be valid date.
	 *
	 * @param array $form_data
	 */
	public function valid_date ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) && $form_data[ 'rule_value' ] === TRUE )
		{
			//Register a error if element rule didn't pass
			$check = strtotime ( $form_data[ 'field_value' ] );
			if ( $check == FALSE )
			{
				//Register error
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
			}
		}
	}

	/**
	 * Check if element value start with some string or number
	 *
	 * @param array $form_data
	 */
	public function start_with ( $form_data = array () )
	{
		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			if ( strpos ( $form_data[ 'field_value' ] , $form_data[ 'rule_value' ] ) !== 0 && ( ! empty( $form_data[ 'field_value' ] ) ) )
			{
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
					$form_data[ 'label' ] ,
					$form_data[ 'rule_value' ]
				) );
			}
		}
	}

	/**
	 * Check if element value not start with some string or number
	 *
	 * @param array $form_data
	 */
	public function not_start_with ( $form_data = array () )
	{

		if ( ! empty( $form_data[ 'field_value' ] ) )
		{
			if ( strpos ( $form_data[ 'field_value' ] , $form_data[ 'rule_value' ] ) === 0 && ( ! empty( $form_data[ 'field_value' ] ) ) )
			{
				$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
					$form_data[ 'label' ] ,
					$form_data[ 'rule_value' ]
				) );
			}
		}
	}

	/**
	 * Check if element value end with some string or number
	 *
	 * @param array $form_data
	 */
	public function ends_with ( $form_data = array () )
	{
		if ( ( ! empty( $form_data[ 'field_value' ] ) ) && ( substr_compare ( $form_data[ 'field_value' ] , $form_data[ 'rule_value' ] , - strlen ( $form_data[ 'rule_value' ] ) , strlen ( $form_data[ 'rule_value' ] ) ) !== 0 ) )
		{
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
				$form_data[ 'label' ] ,
				$form_data[ 'rule_value' ]
			) );
		}
	}

	/**
	 * Check if element value not end with some string or number
	 *
	 * @param array $form_data
	 */
	public function not_ends_with ( $form_data = array () )
	{
		if ( ( ! empty( $form_data[ 'field_value' ] ) ) && ( substr_compare ( $form_data[ 'field_value' ] , $form_data[ 'rule_value' ] , - strlen ( $form_data[ 'rule_value' ] ) , strlen ( $form_data[ 'rule_value' ] ) ) === 0 ) )
		{
			$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array (
				$form_data[ 'label' ] ,
				$form_data[ 'rule_value' ]
			) );
		}
	}

	/**
	 *  ZIP Validation for 12 countries it can be added as multiple countries : array("UK", "NL", "CA") or single : "NL"
	 *
	 * @see  http://www.pixelenvision.com/1708/zip-postal-code-validation-regex-php-code-for-12-countries/
	 *
	 * @param array $form_data
	 */
	public function valid_zip ( $form_data = array () )
	{

		if ( ! empty( $form_data[ 'field_value' ] ))
		{

			$ZIPREG = array (
				"US" => "^\d{5}([\-]?\d{4})?$" ,
				"UK" => "^(GIR|[A-Z]\d[A-Z\d]??|[A-Z]{2}\d[A-Z\d]??)[ ]??(\d[A-Z]{2})$" ,
				"DE" => "\b((?:0[1-46-9]\d{3})|(?:[1-357-9]\d{4})|(?:[4][0-24-9]\d{3})|(?:[6][013-9]\d{3}))\b" ,
				"CA" => "^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])\ {0,1}(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$" ,
				"FR" => "^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$" ,
				"IT" => "^(V-|I-)?[0-9]{5}$" ,
				"AU" => "^(0[289][0-9]{2})|([1345689][0-9]{3})|(2[0-8][0-9]{2})|(290[0-9])|(291[0-4])|(7[0-4][0-9]{2})|(7[8-9][0-9]{2})$" ,
				"NL" => "^[1-9][0-9]{3}\s?([a-zA-Z]{2})?$" ,
				"ES" => "^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$" ,
				"DK" => "^([D-d][K-k])?( |-)?[1-9]{1}[0-9]{3}$" ,
				"SE" => "^(s-|S-){0,1}[0-9]{3}\s?[0-9]{2}$" ,
				"BE" => "^[1-9]{1}[0-9]{3}$"
			);

			if ( is_array ( $form_data[ 'rule_value' ] ) )
			{
				$true = array ();
				foreach ( $form_data[ 'rule_value' ] as $r )
				{
					if ( preg_match ( "/" . $ZIPREG[ $r ] . "/i" , $form_data[ 'field_value' ] ) )
					{
						$true[ ] = TRUE;
					}
				}

				if ( ! in_array ( TRUE , $true ) )
				{
					$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
				}

			}
			else
			{
				if ( ! preg_match ( "/" . $ZIPREG[ $form_data[ 'rule_value' ] ] . "/i" , $form_data[ 'field_value' ] ) )
				{
					//Validation failed, provided zip/postal code is not valid.
					$this->WBB_setErrorTextFormat ( $form_data[ 'element_name' ] , $form_data[ 'rule_name' ] , array ( $form_data[ 'label' ] ) );
				}
			}
		}

	}



	// Security rules--------------------------------------------------------------------

	/**
	 *  XSS Clean
	 *
	 * @param array $form_data
	 */
	public function xss_clean ( $form_data = array () )
	{
		if ( $form_data[ 'rule_value' ] === TRUE )
		{
			// Fix &entity\n;
			$data = str_replace ( array (
				'&amp;' ,
				'&lt;' ,
				'&gt;'
			) , array (
				'&amp;amp;' ,
				'&amp;lt;' ,
				'&amp;gt;'
			) , $form_data[ 'field_value' ] );
			$data = preg_replace ( '/(&#*\w+)[\x00-\x20]+;/u' , '$1;' , $data );
			$data = preg_replace ( '/(&#x*[0-9A-F]+);*/iu' , '$1;' , $data );
			$data = html_entity_decode ( $data , ENT_COMPAT , 'UTF-8' );
			$data = preg_replace ( '#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu' , '$1>' , $data );
			$data = preg_replace ( '#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu' , '$1=$2nojavascript...' , $data );
			$data = preg_replace ( '#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu' , '$1=$2novbscript...' , $data );
			$data = preg_replace ( '#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u' , '$1=$2nomozbinding...' , $data );
			$data = preg_replace ( '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i' , '$1>' , $data );
			$data = preg_replace ( '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i' , '$1>' , $data );
			$data = preg_replace ( '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu' , '$1>' , $data );
			$data = preg_replace ( '#</*\w+:\w[^>]*+>#i' , '' , $data );
			do
			{
				// Remove really unwanted tags
				$old_data = $data;
				$data     = preg_replace ( '#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i' , '' , $data );
			} while ( $old_data !== $data );

			// we are done...
			$_POST[ $form_data[ 'element_name' ] ] = $data;
		}
	}


	/**
	 * Add "http://" or "https://"  to the field
	 *
	 * @param array $form_data
	 */
	public function prep_url ( $form_data = array () )
	{
		if ( $form_data[ 'rule_value' ] === TRUE )
		{
			$str = $form_data[ 'field_value' ];
			if ( substr ( $str , 0 , 7 ) != 'http://' && substr ( $str , 0 , 8 ) != 'https://' )
			{
				$str = 'http://' . $form_data[ 'field_value' ];
			}

			$_POST[ $form_data[ 'element_name' ] ] = $str;
		}
	}

	/**
	 * Convert PHP tags to entities
	 *
	 * @param array $form_data
	 */
	public function encode_php_tags ( $form_data = array () )
	{
		if ( $form_data[ 'rule_value' ] === TRUE )
		{
			$_POST[ $form_data[ 'element_name' ] ] = str_replace ( array (
				'<?php' ,
				'<?PHP' ,
				'<?' ,
				'?>'
			) , array (
				'&lt;?php' ,
				'&lt;?PHP' ,
				'&lt;?' ,
				'?&gt;'
			) , $form_data[ 'field_value' ] );
		}
	}


	/**
	 * Prep data for form
	 * This function allows HTML to be safely shown in a form.
	 * Special characters are converted.
	 *
	 * @param array $form_data
	 */
	public function prep_for_form ( $form_data = array () )
	{

		if ( $form_data[ 'rule_value' ] === TRUE )
		{
			$_POST[ $form_data[ 'element_name' ] ] = str_replace ( array (
				"'" ,
				'"' ,
				'<' ,
				'>'
			) , array (
				"&#39;" ,
				"&quot;" ,
				'&lt;' ,
				'&gt;'
			) , stripslashes ( $form_data[ 'field_value' ] ) );
		}
	}


}