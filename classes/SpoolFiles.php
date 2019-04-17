<?php

class SpoolFiles {
    
    
    private $spaceId;
    private $error = false;
    
    
    public function __construct(array $files) {
        
        foreach( $files as $file ) {
            
            $GLOBALS['logs']->put("fichier traité : {$file}");
            
            $input = json_decode(
                file_get_contents($file),
                true
                );
            
            if ( is_null($input) )  { $GLOBALS['logs']->put(json_last_error().json_last_error_msg()); }
            
            $push = new AutoObject($input['status_report']['sms'][0]);
            
            $this->spaceId = $push->get('space_id');
            
            if ( array_search($this->spaceId, array_keys(Config::get('agences'))) === false ) {
                
                $GLOBALS['logs']->put("spaceId introuvable : {$this->spaceId}");
            }
            else {

                $GLOBALS['logs']->put("-->statut: {$push->get('status')}");
                
                switch ( $push->get('status') ) {
                    
                    case 'ERROR':
                        
                        $this->forwardError($push);
                        break;
                        
                    case 'ABORTED':
                        
                        $this->forwardError($push);
                        break;
                        
                    case 'ANSWERED':
                        
                        $this->forwardAnswer($push);
                        break;
                        
                    default:
                        
                        $GLOBALS['logs']->put('--> ce cas n\'est pas prévu');
                }
            }
            
        }
    }
    
    
    private function forwardAnswer($push) {
        
        $cra = $this->findOrigin($push);
debug($cra);

        $date = date('d/m/Y H:i', (int)substr($cra['lastCall'], 0, 10));
        
        $html = "
            Votre SMS du {$date} vers le numéro {$cra['to']} :<br>
            {$cra['textMsg']}<br><br>
            a reçu une réponse :<br>
            {$cra['callResponse']}
            ";
            
        $mail = sendMail(
            'SMS : réponse reçue',
            $html,
            ['fredericmevollon@universpneus.com']
            // [Config::get('agences')[$spaceId][MAIL]]
            );
        
        $GLOBALS['logs']->put($mail === true ? '--> mail envoyé' : '--> erreur : '.$mail);
    }

    
    private function forwardError($push) {
        
        $cra = $this->findOrigin($push);
debug($cra);

        $date = date('d/m/Y H:i', (int)substr($cra['lastCall'], 0, 10));
        
        $html = "
            Votre SMS du {$date} vers le numéro {$cra['to']} :<br>
            {$cra['textMsg']}<br><br>
            a rencontré une erreur :<br>
            {$cra['lastResult']}
            ";
            
        $mail = sendMail(
            'SMS : erreur détectée',
            $html,
            ['fredericmevollon@universpneus.com']
            // [Config::get('agences')[$spaceId][MAIL]]
            );
        
        $GLOBALS['logs']->put($mail === true ? '--> mail envoyé' : '--> erreur : '.$mail);
    }

    
    private function findOrigin($push) {
        
        $call = new FindCraByIds($this->connection());
        
        $call->sendRequest($push->get('contact_id'));
        
        if ( $call->error() ) {
            
            $GLOBALS['logs']->put($call->message());
            $this->error = true;
        }
        else {
            
            $cra = new AutoObject($call->results()[0]);
// debug($cra);
            
            $date = new \DateTime(date('y-m-d', (int)$cra->get('creationDate')));
            
            $call = new GetSingleCallCra($this->connection());
            
            $call = $call->sendRequest('date', $date->getTimestamp());
            
            if ( $call->error() ) {
                
                $GLOBALS['logs']->put($call->message());
                $this->error = true;
            }
            else {
                
                $listCra = new AutoObject($call->results());
// debug($listCra);        
                
                foreach ( $listCra->get('list') as $single ) {
                    
                    if ( $single['messageId'] == $cra->get('contactId') ) {
                        
                        return $single;
                    }
                }
            }
        }
    }
    
    
    private function connection() {
        
        return [
            "serviceId"         => Config::get('agences')[$this->spaceId][DMC],
            "servicePassword"   => Config::get('agences')[$this->spaceId][MDP],
            "spaceId"           => $this->spaceId
        ];
    }
}