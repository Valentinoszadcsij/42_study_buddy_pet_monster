<?php
namespace App\Utility;

class Mailer
{
    public static function send_email_verification(string $to)
    {
        $code = rand(1000, 9999);
        $message = "Welcome to Camagru\r\nYour verification code is: " . $code;
        $subject = "Email verification";
        $headers = "From: noreply@camagru.com\r\n" . 
                "Reply-to: noreply@camagru.com\r\n" .
                "X-Mailer: PHP/" . phpversion();
        $message = wordwrap($message, 70, "\r\n");

        error_log("Attempting to send mail to: $to");

        $result = mail($to, $subject, $message, $headers);

        if (!$result) {
            error_log("Mail failed to send to $to");
            $_SESSION['error'] = "Failed to send email";
            return -1;
        }
        error_log("Mail sent to $to successfully with code $code");

        return $code;
    }

}
?>
