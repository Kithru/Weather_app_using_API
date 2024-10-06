<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require_once "../Classes/DBConnect.php";

class Mailmanager {


public function mailer($name,$email,$message,$subject) {


$mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'kithru99@gmail.com';                     //SMTP username
            $mail->Password   = 'yuyzvcedifzhaxwd';                               //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress($email, 'KIT');     //Add a recipient
            $mail->addAddress('kithruV@icbtcampus.edu.lk');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return 'sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
    
    public function saveemail($name,$email,$message,$subject) {
        $con = DBConnect::getConnection();
        $date = date("Y-m-d");
        $message = mysql_real_escape_string($message);
        $email = mysql_real_escape_string($email);
        $sql = "INSERT INTO emails (name, email, subject, message, added_date) VALUES ('$name', '$email', '$subject', '$message', '$date')";
        $results = mysql_query($sql, $con) or die("couldn't execute the sql");
        return false;
    }

}