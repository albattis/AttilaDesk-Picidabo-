<?php

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;
require '../../../../vendor/autoload.php';
echo file_get_contents('https://www.howsmyssl.com/a/check');
error_reporting(E_ALL); ini_set('display_errors', 1);
if (isset($_POST['sendEmail']))
{
    $mail = new PHPMailer(true);
    try { // SMTP szerver beállítások
        $mail->SMTPDebug = 3; // vagy 3 a még részletesebb naplózáshoz
        $mail->Debugoutput = 'html';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Freemail SMTP szerver
        $mail->SMTPAuth = true;
        $mail->Username = 'alb12attis12'; // Freemail felhasználónév
        $mail->Password = 'Albattis1212'; // Freemail jelszó
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // TCP port // Címzett és feladó beállítások
        $mail->setFrom('alb12attis12@gmail.com', 'Albert Attila');
        $mail->addAddress('albattis@freemail.hu', 'Recipient Name'); // E-mail tartalom
        $mail->isHTML(true);
        $mail->Subject = 'Here is the subject';
        $mail->Body = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send(); echo 'E-mail sikeresen elküldve.';
    }
    catch (Exception $e)
    {
        echo "Hiba történt az e-mail küldése során. Mailer Error: {$mail->ErrorInfo}";
        var_dump($$mail->ErrorInfo);
    }
}
