<?php

    function sendMail($objet, $message, $adresse, $die=false) {
        
        require_once ('lib/PHPMailer/PHPMailer.php');
        require_once ('lib/PHPMailer/SMTP.php');
        
        $mail = new PHPMailer ();
        
        $mail->isSMTP();
        
        $mail->Host 				= Config::get('mailing/host');
        $mail->Port 				= Config::get('mailing/port');
        $mail->SMTPAuth 			= Config::get('mailing/auth');
        $mail->SMTPSecure 			= Config::get('mailing/secure');
        $mail->Username 			= Config::get('mailing/username');
        $mail->Password 			= Config::get('mailing/password');
        
        $mail->From 				= Config::get('mailing/from');
        $mail->FromName 			= Config::get('mailing/fromname');
        $mail->isHTML( 				true );
        $mail->addReplyTo( 			Config::get('mailing/from'), utf8_decode(Config::get('mailing/fromname')) );
        
        if ( $die ) {
            
            foreach( Config::get('mailing/listBCC') as $adr ) {
                
                $mail->addAddress($adr);
            }
        }
        else {
            foreach( $adresse as $adr ) {
                
                $mail->addAddress($adr);
            }
            foreach( Config::get('mailing/listBCC') as $adr ) {
                
                $mail->addBCC($adr);
            }
        }
        
        $mail->Subject  = utf8_decode($objet);
        $mail->Body 	= utf8_decode($message);
        
        if ( ! $mail->send() ) {
            
            return $mail->ErrorInfo;
        } else {
            return true;
        }
    }

	function debug($var, $console = true) {
	
		if( $GLOBALS['_DEV'] )
		{
			if ($console) {
				
				var_dump($var);
			}
			else
			{
// 				echo "\n<!-- ";
// 				print_r($var);
// 				echo " -->\n";

        	    echo '<pre>';
        	    var_dump($var);
        	    echo '</pre>';
			}
		}
	}
	
	