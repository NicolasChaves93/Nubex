<?php

ini_set("display_errors", 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 require '../lib/PHPMailer/Exception.php';
    require '../lib/PHPMailer/PHPMailer.php';
    require '../lib/PHPMailer/SMTP.php';

//$to = "javierbr1277@gmail.com";
//$subject = "subject correo prueba";
//$body = "cuerpoCorreo";

//envioCorreo($to, $subject, $body);
    
    $body= "
            Nombre : ".$_POST['your-name']."<br>
            Telefono : ".$_POST['your-phone']."<br>
            Telefono : ".$_POST['your-email']."<br>
            Mensaje : ".$_POST['your-message']."<br>
            ";

$retorno = envioCorreo("sales@nubexst.com","Nueva solicitud",$body,null);   
header('Location: ../index.php?correo=1');
exit;
    
function envioCorreo($to = null, $subject, $body, $addBCC = null) {

   

    // Load Composer's autoloader
    //require 'vendor/autoload.php';
    // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
    
    try {
        //Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output


//Usa Gmail
//        $mail->isSMTP();                                            // Send using SMTP
//		$mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
//        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
//        $mail->Username = 'dataenergysystem@gmail.com';                     // SMTP username
//        $mail->Password = '3uddem2020!';                               // SMTP password
//   $mail->SMTPSecure = 'tls';
//        $mail->Port = 587;                                    // TCP port to connect to
		
		
		
//Usa Aruba
       // $mail->isSMTP();                                            // Send using SMTP
		$mail->Host = 'smtp.aruba.it';                    // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'no-reply@dataenergy.org';                     // SMTP username
        $mail->Password = '3uddem2020!';                               // SMTP password
   $mail->SMTPSecure = 'tls';
        $mail->Port = 587;                                    // TCP port to connect to
				
		
		
		
        //Recipients
        $mail->setFrom('no-reply@dataenergy.org', 'Data Energy');
        if(!empty($to)){
        $correos = explode(",", str_replace("/",",",str_replace(";", ",", $to)));
        for($i = 0; $i < count($correos);$i++ ):
            if (filter_var($correos[$i], FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($correos[$i]);               // Name is optional
            }
        endfor;
        }
//        $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
//        $mail->addReplyTo('info@example.com', 'Information');
//        $mail->addCC('cc@example.com');
        if(!empty($addBCC)){
            $correos = explode(",", str_replace("/",",",str_replace(";", ",", $addBCC)));
            for($i = 0; $i < count($correos);$i++ ):
                if (filter_var($correos[$i], FILTER_VALIDATE_EMAIL)) {
                    $mail->addBCC($correos[$i]);
                }
            endfor;
        }
        

        // Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->AltBody = '';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
