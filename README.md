#Overview

***You fill it in and submit it.***

**If you submitted something invalid, or perhaps missed a required item, the form is redisplayed containing your data along with an error message describing the problem.
This process continues until you have submitted a valid form.**

***On the receiving end, the script must:***

- Check for required data.

- Verify that the data is of the correct type, and meets the correct criteria. For example, if a username is submitted it must be validated to contain only permitted characters. It must be of a minimum length, and not exceed a maximum length. The username can't be someone else's existing username, or perhaps even a reserved word. Etc.
Sanitize the data for security.

- Pre-format the data if needed (Does the data need to be trimmed? HTML encoded? Etc.)

- Prep the data for insertion in the database.

**Although there is nothing terribly complex about the above process, it usually requires a significant amount of code, and to display error messages, various control structures are usually placed within the form HTML. Form validation, while simple to create, is generally very messy and tedious to implement.**

#The Form
**Using a text editor, create a form called** ***myform.php***

    <h1>Form 1</h1>
    <p>
        <form method="post" action="form_process.php">

            <p>
                <label for="form1_element1"><?php echo $WBB->WBB_getError ( 'form1_element1' , 'form1' , TRUE ); ?></label><br/>
                <input type="text" name="form1_element1" id="form1_element1" value="<?php $WBB->WBB_getValue ( 'form1_element1' ) ?>">
            </p>

            <p>
                <label for="form1_element1"><?php echo $WBB->WBB_getError ( 'form1_element2' , 'form1' , TRUE ); ?></label><br/>
                <input type="text" name="form1_element2" id="form1_element2" value="<?php $WBB->WBB_getValue ( 'form1_element2' ) ?>">
            </p>

            <p><input type="submit" name="form1" value="submit Form 1"></p>
        </form>
    </p>

#Creating Sets of Rules

In order to organize your rules into "sets" requires that you place them into "sub arrays".

Consider the following example, showing one sets of rules.

We've arbitrarily called "form1" .

You can name your rules anything you want:


    //Set Form 1 rules
    $forms_rules = array (
        //Form1
        'form1' => array (
            'form1_element1' => array (
                'label' => 'Form1 Element1' ,
                'rules' => array (
                    'required' => TRUE
                )
            ) ,
            'form1_element2' => array (
                'label' => 'Form1 Element2' ,
                'rules' => array (
                    'num_between_length' => array (
                        'min' => 5 ,
                        'max' => 10
                    )
                )
            ) ,
        )
    );


#The Process Page
**Using a text editor, create a form called** ***form_process.php***

    <?php

    //Include form validation class
    include ( "WBB_Form_Validation.php" );

    //Set Form 1 rules
    $forms_rules = array (
        //Form1
        'form1' => array (
            'form1_element1' => array (
                'label' => 'Form1 Element1' ,
                'rules' => array (
                    'required' => TRUE
                )
            ) ,
            'form1_element2' => array (
                'label' => 'Form1 Element2' ,
                'rules' => array (
                    'num_between_length' => array (
                        'min' => 5 ,
                        'max' => 10
                    )
                )
            ) ,
        )
    );

    //Init Class
    $WBB = new WBB_Form_Validation();

    //Assign the rules to the class
    $WBB->WBB_setRules ( $forms_rules );

    //Processing Form1
    if ( $WBB->WBB_runForm ( 'form1' ) )
    {
        //Successfully processed form
        echo "Form 1 successfully submitted";
    }
    else
    {
        //Show all errors
        print_r ( $WBB->WBB_getErrors );

    }

    ?>

#Try it!

***To try your form, visit your site using a URL similar to this one:***

***example.com/myform.php If you submit the form you should simply see the form reload.***

***That's because you haven't set up any validation rules yet.***

***Since you haven't told the Form Validation class to validate anything yet, it returns FALSE (boolean false) by default.***

***The WBB_runForm() function only returns TRUE if it has successfully applied your rules without any of them failing.***

#Setting Validation Rules

WBB Form Validation lets you set as many validation rules as you need for a given field, cascading them in order, and it even lets you prep and pre-process the field data at the same time.
To set validation rules you will use the `WBB_setRule()` function:

`$WBB->WBB_setRule ( 'form1_element2' , array ( 'min_length' => 2 ) , 'form1' );`

***The above function takes three parameters as input:***

`form1_element2`
- The exact name you've given the form field.

`array ( 'min_length' => 2 )`
- The form rules applied to the element `form1_element2`

`'form1'`
- The form submitted id

# Setting Custom Error Messages.

***Permits you to set custom error messages.***

All of the native error messages are located in the  `WBB_Form_Validation.php` file in `$WBB_default_error_messages` variable.

To set your own custom message you can either edit that file, or use the following function:

`$WBB->WBB_setCustomErrorMessage ( 'required' , '%s - REQUIRED' );`

`required`
- Corresponds to the name of a particular rule.

`'%s - REQUIRED'`
- The text you would like displayed.

***If you include %s in your error string, it will be replaced with the "human" name you used for your field when you set your rules.***

#Showing Errors as array
You can show all errors in one array variable like this:

`$WBB->WBB_getErrors`

#Showing Errors Individually

If you prefer to show an error message next to each form field, rather than as a array, you can use:

`$WBB->WBB_getError ( 'form1_element1' , 'form1' , TRUE );`

***The above function takes three parameters as input:***

`'form1_element1'`
- The exact name you've given the form field.

`'form1'`
- The form submitted id

`TRUE`
- If is set to true the element label from `$forms_rules` will be included intro the text right after the text error.

#Re-populating the form

Thus far we have only been dealing with errors.

It's time to repopulate the form field with the submitted data. WBB Form Validation offer one function that permit you to do this.

The one you will use is:

`$WBB->WBB_getValue ( 'form1_element1', TRUE )`

 `'form1_element1'`
 - The exact name you've given the form field.

 `TRUE`
 - If this parameter is set top TRUE the function will echo teh value if false the function will return the value, default :false

#Utils functions

***WBB_setRules ( $forms_rules )***

Define values to validate. Set  Form Rules Array

**Parameters**

$forms_rules : The array of the form rules.

**ex:**

    <?php

    //Include form validation class
    include ( "WBB_Form_Validation.php" );

    //Set Form 1 rules
    $forms_rules = array (
        //Form1
        'form1' => array (
            'form1_element1' => array (
                'label' => 'Form1 Element1' ,
                'rules' => array (
                    'required' => TRUE
                )
            ) ,
            'form1_element2' => array (
                'label' => 'Form1 Element2' ,
                'rules' => array (
                    'num_between_length' => array (
                        'min' => 5 ,
                        'max' => 10
                    )
                )
            ) ,
        )
    );

    //Init Class
    $WBB = new WBB_Form_Validation();

    //Assign the rules to the class
    $WBB->WBB_setRules ( $forms_rules );


***WBB_setRule ( $element , $rule_array , $submitted_form_id )***

Add new rule to certain element

**Parameters**

$element : The form element name that the rule should be applied.

$rule_array : The array of the form rules.

$submitted_form_id : The submitted form id.

**ex:**

`$WBB->WBB_setRule ( 'form2_element2' , array ( 'min_length' => 2 ) , 'form2' );`

***WBB_setCustomErrorMessage ( $rule , $error_msg )***

Set Custom  Error Message

**Parameters**

$rule : Rule name

$error_msg : New Rule Error Message

**ex:**

`$WBB->WBB_setCustomErrorMessage ( 'required' , '%s - REQUIRED' );`

***WBB_getError ( $element_name , $submitted_form_id , $show_label = FALSE )***

Get individual element error

**Parameters**

$element_name : The exact name you've given the form field.

$submitted_form_id : The form submitted id

$show_label : If is set to true the element label from `$forms_rules` will be included intro the text right after the text error. Default FALSE

**ex:**

    <p>
        <label
            for="form1_element1"><?php echo $WBB->WBB_getError ( 'form1_element1' , 'form1' , TRUE ); ?></label><br/>
        <input type="text" name="form1_element1" id="form1_element1">
    </p>


***WBB_getValue ( $element_name , $echo = FALSE )***

Get form element value after form was submitted

**Parameters**

$element_name : The exact name you've given the form field.

$echo : If set to TRUE the function will echo the result if set to FALSE it will return the result, default FALSE.

**ex:**

 `<input type="text" name="form2_element3" id="form1_element1"  value="<?php $WBB->WBB_getValue ( 'form1_element1' ) ?>">`

 ***WBB_runForm ( $submit_form_id )***

 Run form validation


 **Parameters**

 $submit_form_id : The form submitted id

 **ex:**

    //Processing Form1
    if ( $WBB->WBB_runForm ( 'form1' ) )
    {
        echo "Form 1 successfully submitted";
    }
    else
    {

        print_r ( $WBB->WBB_getErrors );

    }

 ***WBB_setErrorTextFormat ( $element_name , $rule_name , $vsprintf_data = array () )***

 Set error text format

 **Parameters**

 $element_name :  The exact name you've given the form field.

 $rule_name : The rule name

 $vsprintf_data : Formatted string

 **ex:**

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


#Class defined objects.

***$WBB->WBB_getErrors;***

Get all form validation errors (array)

***$WBB->_WBB_getRules***

Get defined rules

***$WBB->_WBB_formSubmittedData***

Get current form requested data

***$WBB->_WBB_submittedFormId***

Get current submitted form id

***$WBB->_WBB_formSubmittedFiles***

Get current form requested files

***$WBB->WBB_default_error_messages***

Get default Errors Messages

#Rules Functions

***required_file***

Returns FALSE if the form element is empty (only for file's).

**ex:**

    'form2_file_element1' => array(
        'label' => 'Form2 File Element1' ,
        'rules' => array(
            'required_file' => TRUE ,

        )
    ) ,

***allowed_file_types***

Allowed file types works only for files elements, can be added as array or as string, accept only mime types.

**ex as string:**

    'form2_file_element1' => array(
        'label' => 'Form2 File Element1' ,
        'rules' => array(
            'required_file' => TRUE ,
            'allowed_file_types' => 'text/plain|text/xml' ,

        )
    ) ,

**ex as array:**

    'form2_file_element1' => array(
            'label' => 'Form2 File Element1' ,
            'rules' => array(
                'required_file'      => TRUE ,
                'allowed_file_types' => array( 'text/plain','text/xml' ) ,

            )
        ) ,

***required***

Returns FALSE if the form element is empty (only for textarea's and text's).

**ex:**

    'form2_element1'      => array(
        'label' => 'Form2 Element1' ,
        'rules' => array(
            'required' => TRUE
        )
    ) ,

***min_length***

Returns FALSE if the form element is shorter then the parameter value.

**ex:**

    'form1_element2' => array(
        'label' => 'Form1 Element2' ,
        'rules' => array(
            'min_length' => 12
        )
    ) ,

***max_length***

Returns FALSE if the form element is longer then the parameter value.

**ex:**

    'form1_element2' => array(
        'label' => 'Form1 Element2' ,
        'rules' => array(
            'max_length' => 12
        )
    ) ,

***str_between_length***

Returns FALSE if the form element is not between x,y length.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'str_between_length' => array(
                'min' => 4 ,
                'max' => 8
            )
        )
    ) ,

***num_between_length***

Returns FALSE if the form element is not between x,y number.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'num_between_length' => array(
                'min' => 4 ,
                'max' => 8
            )
        )
    ) ,

***word_limit***

Returns FALSE if the form element words number greater then x.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'word_limit' => 12
        )
    ) ,

***exact_length***

Returns FALSE if the form element characters length is not exactly the parameter value.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'exact_length' => 12
        )
    ) ,

***greater_than***

Returns FALSE if the form element is less than the parameter value or not numeric.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'greater_than' => 12
        )
    ) ,

***less_than***

Returns FALSE if the form element is greater than the parameter value or not numeric.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'less_than' => 12
        )
    ) ,

***valid_url***

Returns FALSE if the form element does not contain a valid url.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_url' => TRUE
        )
    ) ,

***real_url***

Returns FALSE if the form element does not contain a real url.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'real_url' => TRUE
        )
    ) ,

***valid_email***

Returns FALSE if the form element does not contain a valid email format.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_email' => TRUE
        )
    ) ,

***valid_emails***

Returns FALSE if the form element does not contain a valid email's.Input emails must be delimited by comma ex. "email1@email.com,email2@email.com" etc...

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_emails' => TRUE
        )
    ) ,

***valid_ip***

Returns FALSE if the form element does not contain a valid IP format.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_ip' => TRUE
        )
    ) ,

***valid_date***

Returns FALSE if the form element does not contain a valid date format.ex: 31-10-1986

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_date' => TRUE
        )
    ) ,

***valid_phone***

Returns FALSE if the form element does not contain a valid phone number format.ex: (1231) 123 123 113, 1234 123123123

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_date' => TRUE
        )
    ) ,

***valid_base64***

Returns FALSE if the form element does not contain a valid phone base64 data format.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_base64' => TRUE
        )
    ) ,

***valid_zip***

Returns FALSE if the form element does not contain a valid zip format.

Allowed countries:

- US
- UK
- DE
- CA
- FR
- IT
- AU
- NL
- ES
- DK
- SE
- BE

**ex single:**

    'valid_zip'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_base64' => 'US'
        )
    ) ,

**ex multiple:**

    'valid_zip'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'valid_base64' => array('US','UK','NL')
        )
    ) ,

***ccnum***

Returns FALSE if the form element does not contain a valid CC number.

CC types:

- Visa,MasterCard
- Discover
- American Express
- Diner's Club, JCB

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
            'ccnum' => TRUE
        )
    ) ,

***regex_match***

Returns FALSE if the form element does not pass certain regular expression rule.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'regex_match' => '/[A-Z]/' ,
        )
    ) ,

***matches***

Returns FALSE if the form element value does not Match to another/s.

**ex as array:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'matches' => array('form2_element3','form2_element4') ,
        )
    ) ,

**ex as string:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'matches' => 'form2_element3|form2_element4' ,
        )
    ) ,

***not_matches***

Returns FALSE if the form element value does Match to another/s.

**ex as array:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'not_matches' => array('form2_element3','form2_element4') ,
        )
    ) ,

**ex as string:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'not_matches' => 'form2_element3|form2_element4' ,
        )
    ) ,

***min_date***

Returns FALSE if the form element is less than the parameter value as date or not valid date format.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'min_date' => '31-10-1986' ,
        )
    ) ,

***max_date***

Returns FALSE if the form element is greater than the parameter value as date or not valid date format.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'max_date' => '31-10-1986' ,
        )
    ) ,

***alpha***

Returns FALSE if the form element not a valid alpha.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'alpha' => TRUE ,
        )
    ) ,

***alpha_numeric***

Returns FALSE if the form element not a valid alpha-numeric.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'alpha_numeric' => TRUE ,
        )
    ) ,

***alpha_dash***

Returns FALSE if the form element not a valid alpha-dash.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'alpha_dash' => TRUE ,
        )
    ) ,

***numeric***

Returns FALSE if the form element is an invalid numeric format..

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'numeric' => TRUE ,
        )
    ) ,

***is_numeric***

Returns FALSE if the form element not a numeric.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'is_numeric' => TRUE ,
        )
    ) ,

***integer***

Returns FALSE if the form element not a integer.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'integer' => TRUE ,
        )
    ) ,

***decimal***

Returns FALSE if the form element not a decimal.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'decimal' => TRUE ,
        )
    ) ,

***is_natural***

Returns FALSE if the form element not a natural.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'is_natural' => TRUE ,
        )
    ) ,

***is_natural_no_zero***

Returns FALSE if the form element not a natural but allowed 0.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'is_natural_no_zero' => TRUE ,
        )
    ) ,

***one_of***

Returns FALSE if the form element is not one of allowed value.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'one_of' => array("This", "Or This", "Or this one also") ,
        )
    ) ,

***start_with***

Returns FALSE if the form element not start with certain substring.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'start_with' => "this" ,
        )
    ) ,

***not_start_with***

Returns FALSE if the form element start with certain substring.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'not_start_with' => "this" ,
        )
    ) ,

***ends_with***

Returns FALSE if the form element not ends with certain substring.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'ends_with' => "this" ,
        )
    ) ,

***not_ends_with***

Returns FALSE if the form element ends with certain substring.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'not_ends_with' => "this" ,
        )
    ) ,

***prep_url***

Adds "http://" to URLs if missing.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'prep_url' => TRUE ,
        )
    ) ,

***encode_php_tags***

Converts PHP tags to entities.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'encode_php_tags' => TRUE ,
        )
    ) ,

***prep_for_form***

Converts special characters so that HTML data can be shown in a form field without breaking it.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'prep_for_form' => TRUE ,
        )
    ) ,

***xss_clean***

Runs the data through the XSS filtering function.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'xss_clean' => TRUE ,
        )
    ) ,

***sanitize_file_name***

Sanitize data for file name

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'sanitize_file_name' => TRUE ,
        )
    ) ,

***normal_chars***

Add normal chars

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'normal_chars' => TRUE ,
        )
    ) ,

***slugify***

Create slugs from strings

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'slugify' => TRUE ,
        )
    ) ,

***strip_image_tags***

Strips the HTML from image tags leaving the raw URL.

**ex:**

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'strip_image_tags' => TRUE ,
        )
    ) ,

***callback***

Use a custom callback function for the element value

**ex:**

    function function_name($data)
    {
        echo $data['field_value'] ;
        echo $data['element_name'] ;
        echo $data['label'] ;
        echo $data['rule_value'] ;
        echo $data['rule_name'] ;
    }

    'form2_element2'      => array(
        'label' => 'Form2 Element2' ,
        'rules' => array(
           'callback' => function_name ,
        )
    ) ,
