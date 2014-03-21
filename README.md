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
      //check https://github.com/webberty/Form-validation-library/blob/master/lib/Form_Validation_Config.php file
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
 ```
### Add rule tag for a particular form element

```
  //Form Validation Config Rules
  include ( "Form_Validation_Config.php" );

  //Load Form Validation Class
  include ( "lib/WBB_Form_Validation_Class.php" );

  //Loading Form Validation Class and pass the Form validation config rules
  $form_validation_class = new WBB_Form_Validation_Class( $form_validation_config );

  $getError              = $form_validation_class;

  //Add Rule tag for a particular form element
  $form_validation_class->WBB_setElementRule ( 'form2' , 'check_required2' , array ( 'word_limit' => 3 ) );

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
### Available Functions:

#### 1) WBB_setRule ( $form_tag , $new_rule_element )
 ```
  $form_validation_class->WBB_setRule ( $form_tag , $new_rule_element );
 ```

 Define value to validate for individual form rule array


 arg : ```$form_tag``` - The form array tag (string)

 ex: ```'form2'```

 arg :  ```$new_rule_element``` - The new form element array (array)

  ex:

  ```
  //Set new element rule
  $new_rule_element = array (
    'field' => 'check_word_limit2' ,
    'label' => 'Element3' ,
    'rules' => array (
      'required'   => TRUE ,
      'word_limit' => 5 ,
    )
  );
  ```

#### 2) WBB_setElementRule ( $form_tag  , $form_element_name , $new_form_element_rule)
```
  $form_validation_class->WBB_setElementRule ( $form_tag  , $form_element_name , $new_form_element_rule);
```

Add rule tag for a particular form element

arg : ```$form_tag``` - The form array tag (string)

ex: ```'form2'```

arg :  ```$form_element_name``` - The form element name (string)

ex: ```'check_required2'```

arg :  ```$new_form_element_rule``` - The new form element rule (array)

ex: ```array ( 'word_limit' => 3 ) ```

#### 3) WBB_setErrorMessage ( $rule_tag , $new_rule_tag_error_message  )
```
  $form_validation_class->WBB_setErrorMessage ( $rule_tag , $new_rule_tag_error_message  );
```

Set custom rule tag error message

arg : ```$rule_tag``` - The rule tag (string)

ex: ```'required'```

arg :  ```$new_rule_tag_error_message ``` - The new rule tag error message (string)

ex: ```'This element -  [%s] is required *'```

### Available Rules
```
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
```






