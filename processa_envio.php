<?php

    require "./biblioteca/PHPMailer/Exception.php";
    require "./biblioteca/PHPMailer/OAuth.php";
    require "./biblioteca/PHPMailer/PHPMailer.php";
    require "./biblioteca/PHPMailer/POP3.php";
    require "./biblioteca/PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Mensagem {

        
    
        private $para = null;
        private $assunto = null;
        private $mensagem = null;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function mensagemValida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            } else {
                return true;
            }
        }
    }

    $mensagem = new Mensagem();
    echo '<br>';
    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    if(!$mensagem->mensagemValida()) {
        echo 'Mensagem não é válida';
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'mathlmarques1@gmail.com';                     //SMTP username
        $mail->Password   = 'ugbm pnmz iwgy ahtl';                               //SMTP password
        $mail->SMTPSecure = 'TLS';              //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('mathlmarques1@gmail.com', 'Matheus Rementente');
        $mail->addAddress($mensagem->__get('para'));     //Add a recipient
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
    
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $mensagem->__get('assunto');
        $mail->Body    = $mensagem->__get('mensagem');
        $mail->AltBody = 'Para ver todo o conteudo do e-mail, utilize um navegador que aceite tags HTML.';
    
        $mail->send();
        echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
        echo 'Não foi possível enviar este e-mail! Por favor tente novamente mais tarde.';
        echo "Detalhes do erro: {$mail->ErrorInfo}";
    }

?>