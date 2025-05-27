<?php
namespace App\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController{
    public function sendPResetEmail(string $email, string $reset_link): bool{
        $mail = new PHPMailer(true);
        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com.';
            $mail->SMTPAuth = true;
            $mail->Username = 'pucusadm@gmail.com';
            $mail->Password = 'sqwh keva haps btqe';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            $mail->setFrom('pucusadm@gmail.com', 'Sistema Pucus');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Seu pedido de redifinição de senha';
            $mail->Body  = " <p> Olá!</p> 
                            <p>Você solicitou a redefinição de sua senha do PUCUS, para concluir a solicitação clique no link abaixo para ser redirecionado para a página correta!</p>
                            <p><a href= '{resetLink}'>Redefinir senha</a></p> 
                            <p>O link tem duração de 1 hora, caso não tenha solicitado a alteração pedimos que desconsidere esse email.</p> 
                            <p>Atenciosamente, PUCUS.<p>";
            $mail->AltBody = "Olá! \n\nVocê solicitou a redefinição de sua senha do PUCUS, para concluir a solicitação clique no link abaixo para ser redirecionado para a página correta!\n{$reset_link}\n\nO link tem duração de 1 hora, caso não tenha solicitado a alteração pedimos que desconsidere esse email.\n\nAtenciosamente, PUCUS."; 
            $mail->send();
            return true;
        }
        catch (Exception $e){
            error_log("Erro ao enviar email: {$mail->ErrorInfo}");
            return false;
        }
    }
}
