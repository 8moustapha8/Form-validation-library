Form validation library
=======================

A PHP Class for Easy Form Validation

### Installation
 `1 - lib/functions.php` :

```
<?php

//Form Validation Config Rules
include ( "Form_Validation_Config.php" );

//Load Form Validation Class
include ( "lib/WBB_Form_Validation_Class.php" );

//Loading Form Validation Class and pass the Form validation config rules
$form_validation_class = new WBB_Form_Validation_Class( $form_validation_config );
$getError              = $form_validation_class;

/**
 * FORM VALIDATION USING ONE SET OF RULES FOR MULTIPLE FORMS
 */
//Check if form 1 was submited
if ( isset( $_POST[ 'form1_submit' ] ) )
{
    //Check if form 1 rule elements  was successfully passed
    if ( $form_validation_class->WBB_formRun ( 'form1' ) )
    {
	  echo "<h1>Form 1 successfully Submited</h1>";
    }
    else
    {
	  //Get all Form validation errors in one array variable
	  $getAllErrors = $form_validation_class->WBB_getAllErrors ();
	  echo '<div class="row"><section><pre>' . print_r ( $getAllErrors , TRUE ) . '</pre></section>';
    }
}

//Check if form 2 was submited
if ( isset( $_POST[ 'form2_submit' ] ) )
{

    //Set New Rule Error Message
    $form_validation_class->WBB_setErrorMessage ( 'required' , 'This element -  [%s] is required *' );

    //Set new element individual element rule
    $new_rule_element = array (
	  'field' => 'check_word_limit2' ,
	  'label' => 'Element3' ,
	  'rules' => array (
		'required'   => TRUE ,
		'word_limit' => 5 ,
	  )

    );
    $form_validation_class->WBB_setRule ( 'form2' , $new_rule_element );

    //Add Rule tag for a particular form element
    $form_validation_class->WBB_setElementRule ( 'form2' , 'check_required2' , array ( 'word_limit' => 3 ) );

    //Check if form 1 rule elements  was successfully passed
    if ( $form_validation_class->WBB_formRun ( 'form2' ) )
    {
	  echo "<h1>Form 1 successfully Submited</h1>";
    }
    else
    {
	  //Get all Form validation errors in one array variable
	  $getAllErrors = $form_validation_class->WBB_getAllErrors ();
	  echo '<div class="row"><section><pre>' . print_r ( $getAllErrors , TRUE ) . '</pre></section>';
    }
}
```
2 - `lib/Form_Validation_Config.php` :

```
   <?php

   /**
    * Load multiple Forms in one form validation rule array
    */
   $form_validation_config = array (
       'form1' => array (
   	  array (
   		'field' => 'check_email' ,
   		'label' => 'Element1' ,
   		'rules' => array (
   		    'valid_email' => TRUE
   		)
   	  ) ,
   	  array (
   		'field' => 'check_max_text' ,
   		'label' => 'Element2' ,
   		'rules' => array (
   		    'max_length' => 10 ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_min_text' ,
   		'label' => 'Element3' ,
   		'rules' => array (
   		    'min_length' => 5 ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_required' ,
   		'label' => 'Element4' ,
   		'rules' => array (
   		    'required' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_valid_url' ,
   		'label' => 'Element5' ,
   		'rules' => array (
   		    'valid_url' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_regex' ,
   		'label' => 'Element6' ,
   		'rules' => array (
   		    'regex_match' => '/^[A-Z]/' , //Detect if string contains 1 uppercase letter
   		)
   	  ) ,
   	  array (
   		'field' => 'check_match_with' ,
   		'label' => 'Field 1' ,
   		'rules' => array (
   		    'matches' => 'check_match_this' ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_match_this' ,
   		'label' => 'Field 2' ,
   		'rules' => array (
   		    'matches' => 'check_match_with' ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_exact_length' ,
   		'label' => 'Element7' ,
   		'rules' => array (
   		    'exact_length' => 5 ,
   		)
   	  ) ,
   	  array (
   		'field' => 'checheck_valid_ip' ,
   		'label' => 'Element8' ,
   		'rules' => array (
   		    'valid_ip' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_alpha' ,
   		'label' => 'Element9' ,
   		'rules' => array (
   		    'alpha' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_alpha_numeric' ,
   		'label' => 'Element10' ,
   		'rules' => array (
   		    'alpha_numeric' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_alpha_dash' ,
   		'label' => 'Element11' ,
   		'rules' => array (
   		    'alpha_dash' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_numeric' ,
   		'label' => 'Element12' ,
   		'rules' => array (
   		    'numeric' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_is_numeric' ,
   		'label' => 'Element13' ,
   		'rules' => array (
   		    'is_numeric' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_integer' ,
   		'label' => 'Element14' ,
   		'rules' => array (
   		    'integer' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_decimal' ,
   		'label' => 'Element15' ,
   		'rules' => array (
   		    'decimal' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_greater_then' ,
   		'label' => 'Element16' ,
   		'rules' => array (
   		    'greater_than' => 3 ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_less_then' ,
   		'label' => 'Element17' ,
   		'rules' => array (
   		    'less_than' => 5 ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_greater_then' ,
   		'label' => 'Element18' ,
   		'rules' => array (
   		    'greater_than' => 3 ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_is_natural' ,
   		'label' => 'Element19' ,
   		'rules' => array (
   		    'is_natural' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_is_natural_no_zero' ,
   		'label' => 'Element20' ,
   		'rules' => array (
   		    'is_natural_no_zero' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_valid64_base' ,
   		'label' => 'Element21' ,
   		'rules' => array (
   		    'valid_base64' => TRUE ,
   		)
   	  ) ,
   	  array (
   		'field' => 'check_word_limit' ,
   		'label' => 'Element22' ,
   		'rules' => array (
   		    'word_limit' => 5 ,
   		)
   	  ) ,
       ) ,
       'form2' => array (
   	  array (
   		'field' => 'check_email2' ,
   		'label' => 'Element1' ,
   		'rules' => array (
   		    'valid_email' => TRUE ,
   		    'required'    => TRUE
   		)
   	  ) ,
   	  array (
   		'field' => 'check_required2' ,
   		'label' => 'Element2' ,
   		'rules' => array (
   		    'required'     => TRUE ,
   		)
   	  ) ,


       )

   );

```
3 - https://github.com/webberty/Form-validation-library/blob/master/lib/WBB_Form_Validation_Class.php

### Set a new rule error message
```
//Form Validation Config Rules
include ( "Form_Validation_Config.php" );

//Load Form Validation Class
include ( "lib/WBB_Form_Validation_Class.php" );

//Loading Form Validation Class and pass the Form validation config rules
$form_validation_class = new WBB_Form_Validation_Class( $form_validation_config );

$getError              = $form_validation_class;

//Set New Rule Error Message
$form_validation_class->WBB_setErrorMessage ( 'required' , 'This element -  [%s] is required *' );


//Check if form 2 was submited
if ( isset( $_POST[ 'form2_submit' ] ) )
{
    //Check if form 1 rule elements  was successfully passed
    if ( $form_validation_class->WBB_formRun ( 'form2' ) )
    {
      echo "<h1>Form 1 successfully Submited</h1>";
    }
    else
    {
      //Get all Form validation errors in one array variable
      $getAllErrors = $form_validation_class->WBB_getAllErrors ();
      echo '<div class="row"><section><pre>' . print_r ( $getAllErrors , TRUE ) . '</pre></section>';
    }
}
```
### Set new element rule
```
//Form Validation Config Rules
include ( "Form_Validation_Config.php" );

//Load Form Validation Class
include ( "lib/WBB_Form_Validation_Class.php" );

//Loading Form Validation Class and pass the Form validation config rules
$form_validation_class = new WBB_Form_Validation_Class( $form_validation_config );

$getError              = $form_validation_class;

//Set new element rule
$new_rule_element = array (
  'field' => 'check_word_limit2' ,
  'label' => 'Element3' ,
  'rules' => array (
    'required'   => TRUE ,
    'word_limit' => 5 ,
  )

);
$form_validation_class->WBB_setRule ( 'form2' , $new_rule_element );

//Check if form 2 was submited
if ( isset( $_POST[ 'form2_submit' ] ) )
{
    //Check if form 1 rule elements  was successfully passed
    if ( $form_validation_class->WBB_formRun ( 'form2' ) )
    {
      echo "<h1>Form 1 successfully Submited</h1>";
    }
    else
    {
      //Get all Form validation errors in one array variable
      $getAllErrors = $form_validation_class->WBB_getAllErrors ();
      echo '<div class="row"><section><pre>' . print_r ( $getAllErrors , TRUE ) . '</pre></section>';
    }
}
