<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Only allow POST requests
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

/**
 * Requires the "PHP Email Form" library
 * The "PHP Email Form" library is available only in the pro version of the template
 * The library should be uploaded to: vendor/php-email-form/php-email-form.php
 * For more info and help: https://bootstrapmade.com/php-email-form/
 */

// Replace with your real receiving email address
$receiving_email_address = 'Danielle.Engelbrecht@capaciti.org.za';

// Check if the PHP Email Form library exists
if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

// Initialize PHP Email Form
$contact = new PHP_Email_Form;
$contact->ajax = true;

// Set the email details
$contact->to = $receiving_email_address;
$contact->from_name = isset($_POST['name']) ? $_POST['name'] : 'No name provided';
$contact->from_email = isset($_POST['email']) ? $_POST['email'] : 'No email provided';
$contact->subject = isset($_POST['subject']) ? $_POST['subject'] : 'No subject provided';

// Uncomment below code to use SMTP. Enter correct SMTP credentials
/*
$contact->smtp = array(
  'host' => 'example.com',
  'username' => 'example',
  'password' => 'pass',
  'port' => '587'
);
*/

// Add message details
$contact->add_message(isset($_POST['name']) ? $_POST['name'] : 'No name provided', 'From');
$contact->add_message(isset($_POST['email']) ? $_POST['email'] : 'No email provided', 'Email');
$contact->add_message(isset($_POST['message']) ? $_POST['message'] : 'No message provided', 'Message', 10);

// Send email and output result
if ($contact->send()) {
    echo 'OK';
} else {
    echo 'Failed to send message!';
}
?>
