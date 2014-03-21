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

