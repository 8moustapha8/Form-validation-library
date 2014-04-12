<?php
/**
 * Created by PhpStorm.
 * User: softmixt
 * Date: 7/04/14
 * Time: 18:56
 */


include ( "WBB_Form_Validation.php" );


$forms_rules = array (
	//Form1
	'form1' => array (

		'form1_element1' => array (
			'label' => 'Form1 Element1' ,
			'rules' => array (
				'regex_match' => '/[A-Z]/'
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

	) ,

	//Form 2
	'form2' => array (
		'form2_element1'      => array (
			'label' => 'Form2 Element1' ,
			'rules' => array ()
		) ,
		'form2_element2'      => array (
			'label' => 'Form2 Element2' ,
			'rules' => array ()
		) ,

		'form2_element3'      => array (
			'label' => 'Form2 Element3' ,
			'rules' => array (
				'valid_zip' =>'US' ,
			)
		) ,

		'form2_file_element1' => array (
			'label' => 'Form2 File Element1' ,
			'rules' => array ()
		) ,
	)


);

$WBB = new WBB_Form_Validation();

$WBB->WBB_setRules ( $forms_rules );

//$WBB->WBB_setRule ( 'form2_element2' , array ( 'min_length' => 2 ) , 'form2' );


//Processing Form1
if ( $WBB->WBB_runForm ( 'form1' ) )
{
	echo "Form 1 successfully submitted";
}
else
{

	print_r ( $WBB->WBB_getErrors );

}

//Processing Form2
if ( $WBB->WBB_runForm ( 'form2' ) )
{
	echo "Form 2 successfully submitted";
}
else
{

	print_r ( $WBB->WBB_getErrors );

}

if ( isset( $_POST[ 'form2_element3' ] ) )
{
	echo "<h2>" . $_POST[ 'form2_element3' ] . "</h2>";
}




?>

	<h1>Form 1</h1>
	<p>
	<form method="post">

		<p>
			<label
				for="form1_element1"><?php echo $WBB->WBB_getError ( 'form1_element1' , 'form1' , TRUE ); ?></label><br/>
			<input type="text" name="form1_element1" id="form1_element1">
		</p>


		<p>
			<label
				for="form1_element1"><?php echo $WBB->WBB_getError ( 'form1_element2' , 'form1' , TRUE ); ?></label><br/>
			<input type="text" name="form1_element2" id="form1_element2">
		</p>

		<p><input type="submit" name="form1" value="submit Form 1"></p>
	</form>
	</p>
	<hr/>
	<h1>Form 2</h1>
	<p>
	<form method="post" enctype="multipart/form-data">

		<p>
			<label
				for="form1_element2"><?php echo $WBB->WBB_getError ( 'form2_element1' , 'form2' , TRUE ); ?></label><br/>
			<input type="text" name="form2_element1" id="form2_element1">
		</p>


		<p>
			<label
				for="form1_element2"><?php echo $WBB->WBB_getError ( 'form2_element2' , 'form2' , TRUE ); ?></label><br/>
			<input type="text" name="form2_element2" id="form2_element2">
		</p>

		<p>
			<label
				for="form1_element3"><?php echo $WBB->WBB_getError ( 'form2_element3' , 'form2' , TRUE ); ?></label><br/>
			<input type="text" name="form2_element3" id="form2_element3">
		</p>

		<p>
			<label
				for="form1_element2"><?php echo $WBB->WBB_getError ( 'form2_file_element1' , 'form2' , TRUE ); ?></label><br/>
			<input type="file" name="form2_file_element1" id="form2_file_element1">
		</p>

		<p><input type="submit" name="form2" value="submit Form 2"></p>
	</form>
	</p>
<?php

$rUsage = getrusage ();
echo 'User time = ' . sprintf ( '%.4f' , ( $rUsage[ 'ru_utime.tv_sec' ] * 1e6 + $rUsage[ 'ru_utime.tv_usec' ] ) / 1e6 ) . ' seconds <br />';
echo 'system time = ' . sprintf ( '%.4f' , ( $rUsage[ 'ru_stime.tv_sec' ] * 1e6 + $rUsage[ 'ru_stime.tv_usec' ] ) / 1e6 ) . ' seconds';

?>