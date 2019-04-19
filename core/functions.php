<?php

    function sendMail($objet, $message, $adresse, $die=false) {
        
        require_once ('lib/PHPMailer/PHPMailer.php');
        require_once ('lib/PHPMailer/SMTP.php');
        
        $conf = $GLOBALS['_DEV'] ? 'mailing_dev/' : 'mailing/';
        
        $mail = new PHPMailer ();
        
        $mail->isSMTP();
        
        $mail->Host 				= Config::get($conf.'host');
        $mail->Port 				= Config::get($conf.'port');
        $mail->SMTPAuth 			= Config::get($conf.'auth');
        $mail->SMTPSecure 			= Config::get($conf.'secure');
        $mail->Username 			= Config::get($conf.'username');
        $mail->Password 			= Config::get($conf.'password');
        
        $mail->From 				= Config::get($conf.'from');
        $mail->FromName 			= Config::get($conf.'fromname');
        $mail->isHTML( 				true );
        $mail->addReplyTo( 			Config::get($conf.'from'), utf8_decode(Config::get($conf.'fromname')) );
        
        if ( $die ) {
            
            foreach( Config::get($conf.'listBCC') as $adr ) {
                
                $mail->addAddress($adr);
            }
        }
        else {
            foreach( $adresse as $adr ) {
                
                $mail->addAddress($adr);
            }
            foreach( Config::get($conf.'listBCC') as $adr ) {
                
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

    function utf8_string_array_encode(&$array){
        
        $func = function(&$value,&$key) {
            
            if(is_string($value)){
                $value = utf8_encode($value);
            }
            if(is_string($key)){
                $key = utf8_encode($key);
            }
            if(is_array($value)){
                $this->utf8_string_array_encode($value);
            }
        };
        
        array_walk($array,$func);
        return $array;
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
	
	