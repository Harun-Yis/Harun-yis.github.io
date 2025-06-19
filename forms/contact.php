<?php
// Your receiving email address
$to = 'haryis35@gmail.com';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Sanitize input
  $name = strip_tags(trim($_POST["name"]));
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $subject = strip_tags(trim($_POST["subject"]));
  $message = trim($_POST["message"]);

  // Validate fields
  if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please fill in all the fields correctly.";
    exit;
  }

  // Prepare email
  $email_subject = "Contact Form: $subject";
  $email_content = "You have received a new message from your website contact form:\n\n";
  $email_content .= "Name: $name\n";
  $email_content .= "Email: $email\n";
  $email_content .= "Subject: $subject\n\n";
  $email_content .= "Message:\n$message\n";

  $email_headers = "From: $name <$email>";

  // Send email
  if (mail($to, $email_subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo "Your message has been sent. Thank you!";
  } else {
    http_response_code(500);
    echo "Sorry, there was a problem sending your message.";
  }
} else {
  http_response_code(403);
  echo "Invalid request method.";
}
?>
