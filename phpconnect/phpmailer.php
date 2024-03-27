<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require(__DIR__ . '/../vendor/autoload.php');

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'quilivh11@gmail.com';                     //SMTP username
    $mail->Password   = 'maiavjeicugunlim';                               //SMTP password
    $mail->SMTPSecure = 'tls';       //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('quilivh11@gmail.com', 'Minh Tam Shop   ');
    $mail->addAddress($username, 'Joe User');     //Add a recipient
    // $mail->addAddress($email);               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset password!';
    $verifycode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    $mail->Body    = '<b>Your code are:' . $verifycode . '</b>';
    include("db.php");
    $username = $_SESSION["username"];
    $insertAccountStmt = $con->prepare("UPDATE verify SET otpcode = ? WHERE username = ?");
    $insertAccountStmt->bind_param("ss", $verifycode, $username);
    if ($insertAccountStmt->execute()) {
        header("Location: /phpconnect/reset.php");
    }
    $mail->AltBody = 'Hello';
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
