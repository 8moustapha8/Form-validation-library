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

***Coming soon.***

#Rules Fucntions

***Coming soon.***