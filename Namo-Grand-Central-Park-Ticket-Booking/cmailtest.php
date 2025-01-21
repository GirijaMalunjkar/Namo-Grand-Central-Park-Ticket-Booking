<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/vendors/vendor/autoload.php';

function SendAEmail($body, $to, $admin) {
    try {
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->SMTPDebug = 0;  // Set to 2 for debugging
        $mail->isSMTP();
        $mail->Host = 'us2.smtp.mailhostbox.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'booking@namograndcentralpark.com';
        $mail->Password = 'XWmoKZo5';
        $mail->SMTPSecure = 'tls'; // or 'ssl'
        $mail->Port = 587; 
        
        // Recipients
        $mail->setFrom('booking@namograndcentralpark.com', 'Namo Grand Central Park');
        $mail->addAddress($to);
        // $mail->addCC($admin);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirm';
        $mail->Body = $body;
        
        $mail->send();
        // echo 'Message has been sent';

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
