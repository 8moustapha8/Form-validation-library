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
	  'required'           => '%s is required.' ,
	  'min_length'         => '%s must be at least  %d characters or longer.' ,
	  'max_length'         => '%s must be no longer than %d characters.' ,
	  'valid_url'          => '%s is an invalid url.' ,
	  'regex_match'        => '%s is an invalid data format.' ,
	  'matches'            => '%s must match %s .' ,
	  'exact_length'       => '%s must be exactly %d characters in length.' ,
	  'valid_email'        => '%s is an invalid email address.' ,
	  'valid_ip'           => '%s is an invalid IP format.' ,
	  'alpha'              => '%s is an invalid alpha format.' ,
	  'alpha_numeric'      => '%s is an invalid alpha-numeric format.' ,
	  'alpha_dash'         => '%s %s is an invalid alpha-dash format.' ,
	  'numeric'            => '%s is an invalid numeric format.' ,
	  'is_numeric'         => '%s is not numeric.' ,
	  'integer'            => '%s must consist of integer value.' ,
	  'decimal'            => '%s must consist of decimal value.' ,
	  'greater_than'       => '%s must be greater than %d .' ,
	  'less_than'          => '%s must be less than %d .' ,
	  'is_natural'         => '%s is not natural.' ,
	  'is_natural_no_zero' => '%s is a Natural number, but not a zero  (1,2,3, etc.)' ,
	  'valid_base64'       => '%s is invalid base 64 data' ,
	  'word_limit'         => '%s must be no longer than %d words.' ,
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
		    $exact_form_array                                                = $this->WBB_form_rules[ $WBB_form_tag ][ $element_nr ][ 'rules' ];
		    $array_merge                                                     = array_merge ( $exact_form_array , $WBB_form_element_rule );
		    $this->WBB_form_rules[ $WBB_form_tag ][ $element_nr ][ 'rules' ] = $array_merge;
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
     * Register errors
     *
     * @param      $key
     * @param      $error_tag
     * @param bool $label
     * @param bool $label_nr
     */
    protected function WBB_registerError ( $key , $error_tag , $label = FALSE , $label_nr = FALSE )
    {

	  $WBB_error_messages       = $this->WBB_default_error_messages;
	  $this->WBB_errors[ $key ] = sprintf ( $WBB_error_messages[ $error_tag ] , $label , $label_nr );
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

	  $post             = isset( $_POST ) && ( ! empty( $_POST ) ) ? $_POST : NULL;
	  $form_array_rules = $this->WBB_form_rules;

	  //Check if form method is post
	  if ( $post )
	  {

		if ( isset( $form_array_rules[ $data ] ) )
		{
		    //Store Current Form Tag Process for a later use
		    $this->WBB_form_rule = $form_array_rules[ $data ];

		    foreach ( $this->WBB_form_rule as $form_rule )
		    {
			  $field       = $form_rule[ 'field' ];
			  $label       = isset( $form_rule[ 'label' ] ) ? $form_rule[ 'label' ] : FALSE;
			  $rules       = isset( $form_rule[ 'rules' ] ) ? $form_rule[ 'rules' ] : FALSE;
			  $field_value = isset( $post[ $field ] ) ? $post[ $field ] : FALSE;

			  //Check If Field Element exist in the form
			  if ( isset( $post[ $field ] ) )
			  {

				if ( $rules )
				{
				    //Go Trough each Rule
				    foreach ( $rules as $rule_key => $rule )
				    {
					  call_user_func_array ( array (
									     $this ,
									     '__' . $rule_key //Callback Function Rule
									 ) , array (
									     $rule_key , //Rule Tag
									     $rule , //Rule Value
									     $field , //Field Name
									     $field_value , //Field Value
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
		if ( ! is_array ( $str ) )
		{
		    $return = ( trim ( $str ) == '' ) ? FALSE : TRUE;
		}
		else
		{
		    $return = ( ! empty( $str ) );
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

	  if ( ! is_numeric ( $str ) && $str < $rule )
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

    // --------------------------------------------------------------------

}