<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
//require 'vendor/autoload.php';
require 'mail/vendors/vendor/autoload.php';
// Instantiation and passing `true` enables exceptions

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 1;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'us2.smtp.mailhostbox.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'booking@namograndcentralpark.com';
        $mail->Password = 'XWmoKZo5';
        $mail->SMTPSecure = 'tls'; // Use 'tls' or 'ssl' depending on your provider
        $mail->Port = 587; // Or 465 for SSL                                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
        //Recipients
        $mail->setFrom('booking@namograndcentralpark.com', 'Namo Grand Central Park');
        $mail->addAddress('narenzanwar@gmail.com');     // Add a recipient
        // $mail->addAddress('djdj1992@gmail.com');               // Name is optional
        // $mail->addReplyTo('anup@devakgroup.in', 'Information');
        // $mail->addCC($admin);
        // $mail->addBCC('');
    
        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Order Confirm';
        $mail->Body    = 'test mail';//$body;
        //$mail->AltBody = $body;
    
        $mail->send();
        echo 'Message has been sent';
    } 
    catch (Exception $e) 
    {
        echo 'PHPMailer Error :: '.$mail->ErrorInfo;
        echo "<br>Message could not be sent. Mailer Error:".$e->getMessage();
    }



?>