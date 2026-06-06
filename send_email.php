<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get and sanitize form data
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // 2. Check if data is valid
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // 3. SET YOUR EMAIL HERE
    $recipient = "hafeezwork99@gmail.com";

    // 4. Set the Subject
    $subject = "New Contact from Portfolio: $name";

    // 5. Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // 6. IMPORTANT: The 'From' header must use an email from YOUR domain
    // Example: if your website is hafeez-designer.com, use info@hafeez-designer.com
    // If you don't have a domain yet, use a placeholder like 'website@your-cpanel-user.com'
    $server_email = "noreply@" . $_SERVER['HTTP_HOST']; 
    
    $headers = "From: Designer Portfolio <$server_email>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n"; // This allows you to click 'Reply' to the user's email
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 7. Send the email
    if (mail($recipient, $subject, $email_content, $headers)) {
        echo "<script>
                alert('Thank you! Your message has been sent successfully.');
                window.location.href='index.html'; 
              </script>";
    } else {
        echo "Error: The server could not send the email. Please check your C-Panel Mail settings or use hafeezwork99@gmail.com directly.";
    }
} else {
    echo "Access denied. Please submit the form from the website.";
}
?>