<?php
//This is a very simple PHP script that outputs the name of each bit of information in the browser window, and then sends it all to an email address you add to the script.

if (empty($_POST)) {
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit();
}

//Creates function that removes magic escaping, if it's been applied, from values and then removes extra newlines and returns to foil spammers.
function clear_user_input($value) {
	if (get_magic_quotes_gpc()) $value=stripslashes($value);
	$value= str_replace( "\n", '', trim($value));
	$value= str_replace( "\r", '', $value);
	return $value;
	}

if ($_POST['comments'] == 'Please share any comments you have here') $_POST['comments'] = '';

//Create body of message by cleaning each field and then appending each name and value to it

$body ="Message from your web site:\n";

foreach ($_POST as $key => $value) {
	if(is_array($value)){ 				// if this post element is a checkbox group or multiple select box
		$value = implode(', ',$value);	// show array of values selected

	}

	$key = clear_user_input($key);
	$value = clear_user_input($value);
	$$key = $value;

	$body .= "$key: $value\n";
}

//Creates header that puts domain-based email in From box, user's email in Reply-To, and name in parentheses
$from='From: '. "no-reply@davidnemiroff.com" . "(" . $name . ")" . "\r\n" . 'Reply-To: '. $email . "(" . $name . ")" . "\r\n";
// replace name@sitedomain.com with a domain-based email address (the domain the form page is on). It doesn't have to be a real address: it just has to be @ the same domain as the form page URL.

//Creates intelligible subject line that shows where it came from
$subject = 'Email from davidnemiroff.com'; // put the site name or url here.

// for troubleshooting, uncomment the two lines below. Send your form, and you'll get a browser message showing your results.
//echo "mail ('name@sitedomain.com', $subject, $body, $from);";
//exit();

//Sends email, with elements created above
//Replace clientname@theirdomain.com with your client's email address. Put your own address here for initial testing, put your client's address for final testing and use.
mail ('davidnemiroff@gmail.com', $subject, $body, $from);


header('Location: thanks.html'); // replace "thanks.html" with the name and path to your actual thank you page
// Be sure to update the url to thanks.php if you use PHP file extensions!
