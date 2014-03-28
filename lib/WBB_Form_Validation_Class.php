<?php

/**
 * Form validation library.
 * @version 1.0.0
 * @author  Baghina Radu Adrian <support@webberty.com>
 * @see     https://github.com/webberty/Form-validation-library.git
 */
class WBB_Form_Validation_Class
{

    /**
     * Store Defined values to validate.
     * @var
     */
    protected $WBB_form_rules;

    /**
     * Get current Form Tag Elements.
     * @var
     */
    protected $WBB_form_rule;

    /**
     * Store Form Errors
     * @var
     */
    protected $WBB_errors;

    /**
     * Default Errors Messages
     * @var
     */
    protected $WBB_default_error_messages = array (
	  'required'                  => '%s is required.' ,
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
	  'prep_url'                  => '' ,
	  'encode_php_tags'           => '' ,
	  'prep_for_form'             => '' ,
	  'xss_clean'                 => '' ,
	  ''                          => '---------------TODO:---------------------------------' ,
	  'start_with'                => '%s must start with %s' ,
	  'not_start_with'            => '%s must not start with %s' ,
	  'ends_with'                 => '%s must end with %s' ,
	  'not_ends_with'             => '%s must not end with %s' ,
	  'min_date'                  => '%s must be a date lather then or equal to %s' ,
	  'max_date'                  => '%s must be a date lather then or equal to %s' ,
	  'one_of'                    => '%s has to be one of the allowed ones %s' ,
	  'callback'                  => '%s' ,
	  'valid_emails'              => '%s has to be valid emails' ,
	  'strip_image_tags'          => '' ,
	  'strip_image_tagsxss_clean' => '' ,
	  'sanitize_file_name'        => '' ,
	  'slugify'                   => '' ,
	  'valid_zip'                 => '%s is invalid ZIP format.' ,
	  'valid_phone'               => '%s is invalid phone format number.' ,

    );


    /**
     * Constructor.
     * Define values to validate.
     *
     * @param array $data
     */
    function __construct ( array $data = NULL )
    {

	  if ( ! empty( $data ) )
	  {
		$this->WBB_setRules ( $data );
	  }
    }


    /**
     * Set Custom  Error Message
     *
     * @param $error_tag
     * @param $message
     */
    public function WBB_setErrorMessage ( $error_tag , $message )
    {

	  $this->WBB_default_error_messages[ $error_tag ] = $message;
    }


    /**
     * Define values to validate.
     * Set  Form Rules Array
     *
     * @param array $WBB_form_array_rules
     */
    public function WBB_setRules ( $WBB_form_array_rules )
    {

	  $this->WBB_form_rules = $WBB_form_array_rules;

    }


    /**
     * Add Rule tag for a particular form element
     *
     * @param $WBB_form_tag
     * @param $WBB_form_element_name
     * @param $WBB_form_element_rule
     */
    public function WBB_setElementRule ( $WBB_form_tag , $WBB_form_element_name , $WBB_form_element_rule )
    {

	  foreach ( $this->WBB_form_rules[ $WBB_form_tag ] as $element_nr => $form_rule )
	  {
		if ( $form_rule[ 'field' ] == $WBB_form_element_name )
		{
		    $this->WBB_form_rules[ $WBB_form_tag ][ $element_nr ][ 'rules' ] = array_merge ( $this->WBB_form_rules[ $WBB_form_tag ][ $element_nr ][ 'rules' ] , $WBB_form_element_rule );;
		}
	  }
    }


    /**
     * Define value to validate.
     * Set Individual Form Rule Array
     *
     * @param $WBB_form_tag
     * @param $WBB_form_array_rules
     */
    public function WBB_setRule ( $WBB_form_tag , $WBB_form_array_rules )
    {

	  $this->WBB_form_rules[ $WBB_form_tag ][ ] = $WBB_form_array_rules;

    }


    /**
     * Get All Registered Errors
     * @return mixed
     */
    public function WBB_getAllErrors ()
    {

	  return $this->WBB_errors;
    }


    /**
     * Get Individual Error name by field name
     *
     * @param $field_name
     *
     * @return string
     */
    public function WBB_getError ( $field_name )
    {

	  return isset( $this->WBB_errors[ $field_name ] ) ? $this->WBB_errors[ $field_name ] : FALSE;
    }


    /**
     *  Register errors
     *
     * @param      $key
     * @param      $error_tag
     * @param bool $label
     * @param bool $label_nr
     * @param bool $label_nr2
     */
    protected function WBB_registerError ( $key , $error_tag , $label = FALSE , $label_nr = FALSE , $label_nr2 = FALSE )
    {

	  $this->WBB_errors[ $key ] = sprintf ( $this->WBB_default_error_messages[ $error_tag ] , $label , $label_nr , $label_nr2 );
    }


    /**
     * Start Form Process
     *
     * @param $form
     *
     * @return bool
     */
    public function WBB_formRun ( $form )
    {

	  $this->WBB_formExecute ( $form );

	  return empty( $this->WBB_errors ) ? TRUE : FALSE;
    }


    /**
     * @param $data
     */
    private function WBB_formExecute ( $data )
    {

	  $post  = isset( $_POST ) && ( ! empty( $_POST ) ) ? $_POST : NULL;
	  $files = isset( $_FILES ) && ( ! empty( $_FILES ) ) ? $_FILES : NULL;

	  //Check if form method is post
	  if ( $post || $files )
	  {

		if ( isset( $this->WBB_form_rules[ $data ] ) )
		{
		    //Store Current Form Tag Process for a later use
		    $this->WBB_form_rule = $this->WBB_form_rules[ $data ];

		    foreach ( $this->WBB_form_rule as $form_rule )
		    {
			  $field       = $form_rule[ 'field' ];
			  $label       = isset( $form_rule[ 'label' ] ) ? $form_rule[ 'label' ] : FALSE;
			  $rules       = isset( $form_rule[ 'rules' ] ) ? $form_rule[ 'rules' ] : FALSE;
			  $field_value = isset( $post[ $field ] ) ? $post[ $field ] : FALSE;
			  $files_value = isset( $files[ $field ] ) ? $files[ $field ] : FALSE;

			  //Check If Field Element exist in the form
			  if ( isset( $post[ $field ] ) || isset( $files[ $field ] ) )
			  {

				if ( $rules )
				{
				    //Go Trough each Rule
				    foreach ( $rules as $rule_key => $rule )
				    {
					  $field_data_value = FALSE;
					  if ( $field_value )
					  {
						$field_data_value = $field_value;
					  }
					  elseif ( $files_value )
					  {
						$field_data_value = $files_value;
					  }
					  call_user_func_array ( array (
									     $this ,
									     '__' . $rule_key //Callback Function Rule
									 ) , array (
									     $rule_key , //Rule Tag
									     $rule , //Rule Value
									     $field , //Field Name
									     $field_data_value , //Field Value
									     $label //Field Label
									 ) );
				    }
				}
			  }

		    }

		};
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Word Limit
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __word_limit ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( str_word_count ( $str ) > $rule )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label , $rule );
	  }
    }

    // -------------------------------------------------------------------- // --------------------------------------------------------------------

    /**
     * Validate URL
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __valid_url ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
		if ( ! preg_match ( $pattern , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }
    // --------------------------------------------------------------------

    /**
     * Check for a real URL
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __real_url ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( @fsockopen ( "$str" , 80 , $errno , $errstr , 30 ) == FALSE )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------


    /**
     * Required
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __required ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		//Check For Required File
		if ( isset( $_FILES[ $field ] ) )
		{
		    $return = ( ! empty( $str[ 'name' ] ) );
		}
		else
		{
		    if ( ! is_array ( $str ) )
		    {
			  $return = ( trim ( $str ) == '' ) ? FALSE : TRUE;
		    }
		    else
		    {
			  $return = ( ! empty( $str ) );
		    }
		}

		if ( $return == FALSE )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Performs a Regular Expression match test.
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __regex_match ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( ! (bool) preg_match ( $rule , $str ) )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label );
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Match one field to another
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __matches ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( isset( $_POST[ $field ] ) )
	  {
		//
		if ( $str !== $_POST[ $rule ] )
		{
		    $other_field = FALSE;
		    foreach ( $this->WBB_form_rule as $form_rule )
		    {

			  if ( $form_rule[ 'field' ] == $rule )
			  {
				if ( isset( $form_rule[ 'label' ] ) )
				{
				    $other_field = $form_rule[ 'label' ];
				}
			  }
		    }

		    $this->WBB_registerError ( $field , $rule_key , $label , $other_field );
		}
	  }
    }
    // --------------------------------------------------------------------

    /**
     * Match one field to another
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __not_matches ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( isset( $_POST[ $field ] ) )
	  {
		//
		if ( $str == $_POST[ $rule ] )
		{
		    $other_field = FALSE;
		    foreach ( $this->WBB_form_rule as $form_rule )
		    {

			  if ( $form_rule[ 'field' ] == $rule )
			  {
				if ( isset( $form_rule[ 'label' ] ) )
				{
				    $other_field = $form_rule[ 'label' ];
				}
			  }
		    }

		    $this->WBB_registerError ( $field , $rule_key , $label , $other_field );
		}
	  }
    }


    // --------------------------------------------------------------------


    /**
     * Minimum Length
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __min_length ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( strlen ( $str ) < $rule || preg_match ( "/[^0-9]/" , $rule ) )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label , $rule );
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Max Length
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __max_length ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( strlen ( $str ) > $rule || preg_match ( "/[^0-9]/" , $rule ) )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label , $rule );
	  }
    }

    // --------------------------------------------------------------------

    /**
     * String Between Length
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __str_between_length ( $rule_key , $rule , $field , $str , $label )
    {

	  $check_between = isset( $rule[ 'min' ] ) && $rule[ 'max' ] && ( ( mb_strlen ( $str ) >= $rule[ 'min' ] && mb_strlen ( $str ) <= $rule[ 'max' ] ) );
	  if ( ! $check_between )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label , $rule[ 'min' ] , $rule[ 'max' ] );
	  }
    }

    // --------------------------------------------------------------------
    /**
     * Number Between x, y
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __num_between_length ( $rule_key , $rule , $field , $str , $label )
    {

	  $check_between = FALSE;
	  if ( preg_match ( '/^[\-+]?[0-9]*\.?[0-9]+$/' , $str ) )
	  {
		$check_between = isset( $rule[ 'min' ] ) && isset( $rule[ 'max' ] ) && $str >= $rule[ 'min' ] && $str <= $rule[ 'max' ];
	  }

	  if ( ! $check_between )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label , $rule[ 'min' ] , $rule[ 'max' ] );
	  }

    }

    // --------------------------------------------------------------------

    /**
     * Exact Length
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __exact_length ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( strlen ( $str ) != $rule || preg_match ( "/[^0-9]/" , $rule ) )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label , $rule );
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Valid Email
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __valid_email ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! preg_match ( "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix" , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Validate IP Address
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __valid_ip ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( filter_var ( $str , FILTER_VALIDATE_IP ) == FALSE )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Valid Alpha
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __alpha ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! preg_match ( "/^([a-z])+$/i" , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __alpha_numeric ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! preg_match ( "/^([a-z0-9])+$/i" , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __alpha_dash ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! preg_match ( "/^([-a-z0-9_-])+$/i" , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Numeric
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __numeric ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! preg_match ( '/^[\-+]?[0-9]*\.?[0-9]+$/' , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------
    /**
     * Is Numeric ?
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __is_numeric ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! is_numeric ( $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Integer
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __integer ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! (bool) preg_match ( '/^[\-+]?[0-9]+$/' , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Decimal number
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __decimal ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! (bool) preg_match ( '/^[\-+]?[0-9]+\.[0-9]+$/' , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Greather than
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __greater_than ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( ! is_numeric ( $str ) && $str > $rule )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label , $rule );
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Less than
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __less_than ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( ! is_numeric ( $str ) || ( $str > $rule ) )
	  {
		$this->WBB_registerError ( $field , $rule_key , $label , $rule );
	  }
    }

    // --------------------------------------------------------------------

    /**
     *  Is a Natural number  (0,1,2,3, etc.)
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __is_natural ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! (bool) preg_match ( '/^[0-9]+$/' , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Is a Natural number, but not a zero  (1,2,3, etc.)
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __is_natural_no_zero ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! preg_match ( '/^[0-9]+$/' , $str ) || $str == 0 )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Valid Base64
     * Tests a string for characters outside of the Base64 alphabet
     * as defined by RFC 2045 http://www.faqs.org/rfcs/rfc2045
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __valid_base64 ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! (bool) preg_match ( '/[^a-zA-Z0-9\/\+=]/' , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }

	  return;
    }


    // -------------------------------------------------------------------- // --------------------------------------------------------------------

    /**
     * Field must be a valid credit card number format
     * CC types: Visa,MasterCard, Discover , American Express,Diner's Club, JCB
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     *
     * @return bool
     */
    private function __ccnum ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( ! (bool) preg_match ( '/^(?:4\d{3}[ -]*\d{4}[ -]*\d{4}[ -]*\d(?:\d{3})?|5[1-5]\d{2}[ -]*\d{4}[ -]*\d{4}[ -]*\d{4}|6(?:011|5[0-9]{2})[ -]*\d{4}[ -]*\d{4}[ -]*\d{4}|3[47]\d{2}[ -]*\d{6}[ -]*\d{5}|3(?:0[0-5]|[68][0-9])\d[ -]*\d{6}[ -]*\d{4}|(?:2131|1800)[ -]*\d{6}[ -]*\d{5}|35\d{2}[ -]*\d{4}[ -]*\d{4}[ -]*\d{4})$/' , $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Field must be number between X and Y.
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     *
     * @return bool
     */
    private function __between ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( is_array ( $rule ) )
		{
		    $betwee_val = $rule;
		}
		else
		{
		    $betwee_val = explode ( ',' , $rule );
		}
		if ( in_array ( $str , call_user_func_array ( "range" , $betwee_val ) ) == FALSE || ! is_numeric ( $str ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label , $betwee_val[ 0 ] , $betwee_val[ 1 ] );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * XSS Clean
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     *
     * @return mixed|string
     */
    private function __xss_clean ( $rule_key , $rule , $field , $str , $label = FALSE )
    {

	  if ( $rule && $rule_key == 'xss_clean' )
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
					    ) , $str );
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
		$_POST[ $field ] = $data;
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Field must be valid date.
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     *
     * @return bool
     */
    private function __valid_date ( $rule_key , $rule , $field , $str , $label )
    {

	  if ( $rule )
	  {
		if ( strtotime ( $str ) == FALSE )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }
    }

    // --------------------------------------------------------------------

    /**
     * Add "http://" or "https://"  to the field
     *
     * @param $rule_key
     * @param $rule
     * @param $field
     * @param $str
     * @param $label
     */
    private function __prep_url ( $rule_key , $rule , $field , $str , $label = NULL )
    {

	  if ( $rule && $rule_key == 'prep_url' )
	  {
		if ( substr ( $str , 0 , 7 ) != 'http://' && substr ( $str , 0 , 8 ) != 'https://' )
		{
		    $str = 'http://' . $str;
		}

		$_POST[ $field ] = $str;
	  }
    }
    // --------------------------------------------------------------------

    /**
     * Convert PHP tags to entities
     *
     * @param      $rule_key
     * @param      $rule
     * @param      $field
     * @param      $str
     * @param null $label
     *
     * @return mixed.
     */
    private function __encode_php_tags ( $rule_key , $rule , $field , $str , $label = NULL )
    {

	  if ( $rule && $rule_key == 'encode_php_tags' )
	  {
		$_POST[ $field ] = str_replace ( array (
								 '<?php' ,
								 '<?PHP' ,
								 '<?' ,
								 '?>'
							   ) , array (
								 '&lt;?php' ,
								 '&lt;?PHP' ,
								 '&lt;?' ,
								 '?&gt;'
							   ) , $str );
	  }

    }


    // --------------------------------------------------------------------
    private function __allowed_file_types ( $rule_key , $rule , $field , $str = NULL , $label )
    {

	  if ( isset( $_FILES[ $field ] ) && ( ! empty( $_FILES[ $field ][ 'name' ] ) ) )
	  {
		$file_input_data = $_FILES[ $field ];

		if ( ! in_array ( $file_input_data[ 'type' ] , $rule ) )
		{
		    $this->WBB_registerError ( $field , $rule_key , $label );
		}
	  }

    }

    // --------------------------------------------------------------------

    /**
     * Prep data for form
     * This function allows HTML to be safely shown in a form.
     * Special characters are converted.
     *
     * @param      $rule_key
     * @param      $rule
     * @param      $field
     * @param      $str
     * @param null $label
     */
    private function __prep_for_form ( $rule_key , $rule , $field , $str , $label = NULL )
    {

	  if ( $rule && $rule_key == 'prep_for_form' )
	  {
		$_POST[ $field ] = str_replace ( array (
								 "'" ,
								 '"' ,
								 '<' ,
								 '>'
							   ) , array (
								 "&#39;" ,
								 "&quot;" ,
								 '&lt;' ,
								 '&gt;'
							   ) , stripslashes ( $str ) );
	  }
    }

}
