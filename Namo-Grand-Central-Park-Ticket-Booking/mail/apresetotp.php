<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
//require 'vendor/autoload.php';
require 'vendors/vendor/autoload.php';
// Instantiation and passing `true` enables exceptions

// https://docs.aws.amazon.com/general/latest/gr/rande.html#ses_region
function SendAEmail($body, $to, $admin) {
    try {
        $mail = new PHPMailer(true);
        
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.zoho.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'noreply@scinotic.com';                     // SMTP username
        $mail->Password   = 'Scinotic@$5';                               // SMTP password
        $mail->SMTPAutoTLS = false;
        $mail->SMTPSecure = false;
        $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;
        $mail->Debugoutput = 'html';                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        
        $mail->setFrom('noreply@scinotic.com', 'Aquasplash');

        $mail->addAddress($to);     // Add a recipient 
         $mail->addCC($admin);  
    
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Agent Password Reset OTP';
        $mail->Body    = $body; 
    
        $mail->send();
        //echo 'Message has been sent';
    } 
    catch (Exception $e) 
    {
        echo "Message could not be sent. Mailer Error:";
    }
}



?>