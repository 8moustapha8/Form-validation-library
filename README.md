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
        <form method="post">

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
