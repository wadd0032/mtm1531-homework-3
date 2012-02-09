<?php

error_reporting(-1);
ini_set('display_errors', 'on');

include 'includes/filter-wrapper.php';

/*$possible_subjects = array(
	'English'
	, 'French'
	, 'Spanish'
);
*/
$possible_preferredlang = array(
	'en' => 'English'
	, 'fr' => 'French'
	, 'sp' => 'Spanish'
);

$errors = array();
$display_thanks = false;

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
$preferredlang = filter_input(INPUT_POST, 'preferredlang', FILTER_SANITIZE_STRING);
$notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
$terms = filter_input(INPUT_POST, 'terms', FILTER_DEFAULT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (empty($name)) {
		$errors['name'] = true;
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = true;
	}
	
	if (mb_strlen($username) < 1 || strlen($username) > 25) {
		$errors['username'] = true;
	}
	
	if (empty($password)) {
		$errors['password'] = true;
	}

	if (!array_key_exists($preferredlang, $possible_preferredlang)) {
		$errors['preferredlang'] = true;
	}
	
		if (empty($terms)) {
		$errors['terms'] = true;
	}
	
	if (empty($errors)) {
		$display_thanks = true;
				
		mail($email, 'Thanks for registering', "From: Deanna Wadden <deannawadden@rogers.com>\r\n")	;
	}
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Registration Form Validation</title>
	<link href="css/general.css" rel="stylesheet">
</head>
<body>
	
	<?php if ($display_thanks) : ?>
	
		<strong>Thanks for registering!</strong>
	
	<?php else : ?>
	
	<form method="post" action="index.php">
		<div>
			<label for="name">Name<?php if (isset($errors['name'])) : ?> <strong>* Required</strong><?php endif; ?></label>
			<input type="text" id="name" name="name" value="<?php echo $name; ?>" >
		</div>
		<div>
			<label for="email">E-mail Address<?php if (isset($errors['email'])) : ?> <strong>* Required</strong><?php endif; ?></label>
			<input type="email" id="email" name="email" value="<?php echo $email; ?>" >
		</div>
        <div>
			<label for="username">Username<?php if (isset($errors['username'])) : ?> <strong>* Please enter a username of less than 25 characters</strong><?php endif; ?></label>
			<input type="text" id="username" name="username" value="<?php echo $username; ?>" >
		</div>
        <div>
			<label for="password">Password<?php if (isset($errors['password'])) : ?> <strong>* Required</strong><?php endif; ?></label>
			<input type="password" id="password" name="password" value="<?php echo $password; ?>" >
		</div>
		<fieldset>
			<legend>Preferred Language</legend>
			<?php if (isset($errors['preferredlang'])) : ?><p><strong>Select a preferred language</strong></p><?php endif; ?>
		<?php foreach ($possible_preferredlang as $key => $value) : ?>
			<input type="radio" id="<?php echo $key; ?>" name="preferredlang" value="<?php echo $key; ?>"<?php if ($key == $preferredlang) { echo ' checked'; } ?>>
			<label for="<?php echo $key; ?>"><?php echo $value; ?></label>
		<?php endforeach; ?>
		</fieldset>
		<div>
			<label for="notes">Notes</label>
			<textarea id="notes" name="notes"><?php echo $notes; ?></textarea>
		</div>
		<div id="checkbox">
			<input type="checkbox" id="terms" name="terms" <?php if (!empty($terms)) { echo 'checked'; } ?>>
			<label for="terms">Accept terms?</label>
			<?php if (isset($errors['terms'])) : ?><strong>You must comply! Resistance is futile!</strong><?php endif; ?>
		</div>
		<div>
			<button type="submit">Send Message</button>
		</div>
	</form>
	
	<?php endif; ?>
	
</body>
</html>











