<?php

class SpoolFiles {
    
    public function __construct(array $files) {
        
        foreach( $files as $file ) {
            
            $GLOBALS['logs']->put("fichier traité : {$file}");
            
            $input = json_decode(
                file_get_contents($file),
                true
                );
            
            if ( is_null($input) )  { $GLOBALS['logs']->put(json_last_error().json_last_error_msg()); }
            
            $push = new AutoObject($input['status_report']['sms'][0]);
            
            $spaceId = $push->get('space_id');
            
            if ( array_search($spaceId, array_keys(Config::get('agences'))) === false ) {
                
                $GLOBALS['logs']->put("spaceId introuvable : {$spaceId}");
            }
            else {
                
                switch ( $push->get('status') ) {
                    
                    case 'ERROR':
                        
                        $this->forwardError($spaceId, $push);
                        break;
                        
                    case 'ABORTED':
                        
                        $this->forwardError($spaceId, $push);
                        break;
                        
                    case 'ANSWERED':
                        
                        $this->forwardAnswer($spaceId, $push);
                        break;
                        
                    default:
                        
                        $GLOBALS['logs']->put('--> ce cas n\'est pas prévu');
                }
            }
            
        }
    }
    
    private function forwardAnswer($spaceId, $push) {
        
        
        $call = new FindCraByIds($this->connection($spaceId));
        
        $response = $call->sendRequest($push->get('contact_id'));
        
        if ( $response->error() ) {
            
            $GLOBALS['logs']->put($response->message());
        }
        else {
            
            $cra = new AutoObject($response->results()[0]);
debug($cra);
            $date = new \DateTime(date('y-m-d', (int)$cra->get('creationDate')));
            
            $call = new GetSingleCallCra($this->connection($spaceId));
            
            $response = $call->sendRequest('date', $date->getTimestamp());
            
            if ( $response->error() ) {
                
                $GLOBALS['logs']->put($response->message());
            }
            else {
                
                foreach ( $response->results()['list'] as $single ) {
                    
                    if ( $single['messageId'] == $cra->get('contactId') ) {
                        
                        $date = date('d/m/Y H:i', (int)substr($cra->get('creationDate'), 0, 10));
                        
                        $html = "
                            Votre SMS du {$date} vers le numéro {$single['to']} :<br>
                            {$single['textMsg']}<br><br>
                            a reçu une réponse :<br>
                            {$single['callResponse']}
                            ";
                            
                            $mail = sendMail(
                                'SMS : réponse reçue',
                                $html,
                                ['fredericmevollon@universpneus.com']
                                //                     	    [Config::get('agences')[$spaceId][MAIL]]
                                );
                            
                            $GLOBALS['logs']->put($mail === true ? '--> mail envoyé' : '--> '.$mail);
                    }
                }
            }
        }
    }
    
    private function connection(string $spaceId) {
        
        return [
            "serviceId"         => Config::get('agences')[$spaceId][DMC],
            "servicePassword"   => Config::get('agences')[$spaceId][MDP],
            "spaceId"           => $spaceId
        ];
    }
}