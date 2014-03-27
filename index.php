<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="./assets/ico/favicon.ico">

    <title>Form Validation Example</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>


<div class="container">

    <?php include ( "lib/functions.php" ); ?>


    <form id="form1" name="form1" class="form-signin col-lg-7" role="form" method="post" enctype="multipart/form-data">

	  <p>

	  <h2 class="form-signin-heading ">Single element rule</h2>
	  <?php echo $getError->WBB_getError ( 'check_email' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_email' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control top-text-element" name="check_email" placeholder="email address">

	  <?php echo $getError->WBB_getError ( 'check_max_text' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_max_text' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_max_text"
		   placeholder="maximum text length (10)">

	  <?php echo $getError->WBB_getError ( 'check_min_text' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_min_text' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_min_text"
		   placeholder="minimum text length (6)">

	  <?php echo $getError->WBB_getError ( 'check_required' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_required' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_required" placeholder="required">

	  <?php echo $getError->WBB_getError ( 'check_valid_url' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_valid_url' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_valid_url" placeholder="valid url">

	  <?php echo $getError->WBB_getError ( 'check_regex' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_regex' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_regex"
		   placeholder="Only uppercase letters">

	  <?php echo $getError->WBB_getError ( 'check_match_with' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_match_with' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_match_with" placeholder="Field1 matches to">

	  <?php echo $getError->WBB_getError ( 'check_match_this' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_match_this' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_match_this" placeholder="Field2 this">

	  <?php echo $getError->WBB_getError ( 'check_exact_length' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_exact_length' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_exact_length" placeholder="exact length">

	  <?php echo $getError->WBB_getError ( 'check_valid_ip' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_valid_ip' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_valid_ip" placeholder="valid ip">

	  <?php echo $getError->WBB_getError ( 'check_alpha' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_alpha' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_alpha" placeholder="alpha">

	  <?php echo $getError->WBB_getError ( 'check_alpha_numeric' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_alpha_numeric' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_alpha_numeric" placeholder="alpha numeric">

	  <?php echo $getError->WBB_getError ( 'check_alpha_dash' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_alpha_dash' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_alpha_dash" placeholder="alpha dash">

	  <?php echo $getError->WBB_getError ( 'check_numeric' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_numeric' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_numeric" placeholder="numeric">

	  <?php echo $getError->WBB_getError ( 'check_is_numeric' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_is_numeric' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_is_numeric" placeholder="is numeric">

	  <?php echo $getError->WBB_getError ( 'check_integer' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_integer' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_integer" placeholder="integer">

	  <?php echo $getError->WBB_getError ( 'check_decimal' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_decimal' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_decimal" placeholder="decimal">

	  <?php echo $getError->WBB_getError ( 'check_greater_then' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_greater_then' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_greater_then" placeholder="greater than">

	  <?php echo $getError->WBB_getError ( 'check_less_then' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_less_then' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_less_then" placeholder="less than">

	  <?php echo $getError->WBB_getError ( 'check_is_natural' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_is_natural' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_is_natural" placeholder="is natural">

	  <?php echo $getError->WBB_getError ( 'check_is_natural_no_zero' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_is_natural_no_zero' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_is_natural_no_zero"
		   placeholder="is natural no zero">

	  <?php echo $getError->WBB_getError ( 'check_valid64_base' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_valid64_base' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_valid64_base" placeholder="valid base 64">

	  <?php echo $getError->WBB_getError ( 'check_real_url' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_real_url' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control normal-text " name="check_real_url" placeholder="Real url">

	  <?php echo $getError->WBB_getError ( 'check_word_limit' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_word_limit' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control  normal-text" name="check_word_limit"
		   placeholder="word limit max 5 words">

	  <?php echo $getError->WBB_getError ( 'check_between_numbers' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_between_numbers' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control  normal-text" name="check_between_numbers"
		   placeholder="check between 12 and 31">

	  <?php echo $getError->WBB_getError ( 'check_valid_date' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_valid_date' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control  normal-text" name="check_valid_date"
		   placeholder="validate date format">

	  <?php echo $getError->WBB_getError ( 'check_credit_card_number' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_credit_card_number' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control  bottom-text-element" name="check_credit_card_number"
		   placeholder="valid credit card number format">
	  </p>

	  <p>
		<input type="submit" class="btn btn-lg btn-primary btn-block" name="form1_submit" value="Check">
	  </p>
    </form>


    <form id="form2" name="form2" class="form-signin col-lg-7" role="form" method="post" enctype="multipart/form-data">

	  <p>

	  <h2 class="form-signin-heading">Multiple elements rules</h2>
	  <?php echo $getError->WBB_getError ( 'check_email2' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_email2' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control top-text-element" name="check_email2" placeholder="email address"
		   placeholder="word limit max 5 words">

	  <?php echo $getError->WBB_getError ( 'check_required2' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_required2' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control  normal-text  " name="check_required2" placeholder="required">

	  <?php echo $getError->WBB_getError ( 'check_word_limit2' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_word_limit2' ) . '</span>' : ''; ?>
	  <input type="text" class="form-control bottom-text-element" name="check_word_limit2"
		   placeholder="Check words limit">

	  <?php

	  if(isset($_POST['form2_submit']))
	  {

		if ( isset( $_FILES[ 'check_file_type' ] ) )
		{
		    print_r($_FILES['check_file_type']) ;
		}
	  }

	  ?>


	  <?php echo $getError->WBB_getError ( 'check_file_type' ) ? '<span class="label label-danger">' . $getError->WBB_getError ( 'check_file_type' ) . '</span>' : ''; ?>
	  <input type="file" name="check_file_type" value="s">

	  </p>

	  <p>
		<input type="submit" class="btn btn-lg btn-primary btn-block" name="form2_submit" value="Check">
	  </p>
    </form>
</div>
<!-- /container -->


<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
