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
