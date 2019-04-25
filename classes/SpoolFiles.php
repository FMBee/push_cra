<?php

class SpoolFiles {
    
    
    private $logs;
    private $spaceId;
    private $error;
    
    
    public function __construct(array $files) {
        
        $this->logs = new Log(Config::get('logs/push'));
        
        if ( $this->logs->error() ) {
            
            echo('Erreur sur fichier log');
            return;
        }
        
        if ( empty($files) ) {
            
            echo("Aucun fichier a traiter");
            return;            
        }

        $this->logs->init();
        
        foreach( $files as $file ) {
            
            $this->error = false;
            $this->logs->put("fichier traite : {$file}");
            
            $input = json_decode(
                file_get_contents($file),
                true
                );
            
            if ( is_null($input) )  { 
                
                $this->logs->put(json_last_error().json_last_error_msg()); 
            }
            else {
                
                $push = new AutoObject($input['status_report']['sms'][0]);
                
                $this->spaceId = $push->get('space_id');
                
                if ( array_search($this->spaceId, array_keys(Config::get('agences'))) === false ) {
                    
                    $this->logs->put("spaceId introuvable : {$this->spaceId}");
                }
                else {
    
                    $this->logs->put("--> statut: {$push->get('status')}");
                    
                    if ( in_array(
                        $push->get('status'), 
                        ['ERROR', 'ABORTED', 'ANSWERED']
                        ) ) {
                            
                        $this->forwardResult($push);
                    }
                    else {
                        $this->logs->put('--> non traite');
                    }
                }
            }
            
            rename($file, Config::get('params/moveDir').$file);
        }
        
        $this->logs->close();
    }
    
    
    private function forwardResult(AutoObject $push) {
        
        $this->findOrigin($push, $cra, $craInfo);
// debug($cra);
// debug($craInfo);

        if ( !$this->error ) {
            
            $date = date('d/m/Y H:i', (int)substr($cra->get('creationDate'), 0, 10));

            switch ( $push->get('status') ) {
                
                case 'ANSWERED':
                    
                    $html = "
                        Votre SMS du {$date} vers le numéro {$craInfo->get('to')} :<br>
                        {$craInfo->get('textMsg')}<br><br>
                        a reçu une réponse :<br>
                        {$craInfo->get('callResponse')}
                        ";
                        
                    $object = "SMS au {$craInfo->get('to')} : réponse reçue";
                    break;
                    
                default:
                    
                    $html = "
                        Votre SMS du {$date} vers le numéro {$craInfo->get('to')} :<br>
                        {$craInfo->get('textMsg')}<br><br>
                        a rencontré une erreur :<br>
                        {$craInfo->get('lastResult')} / 
                        ".utf8_decode($push->get('status_list')[0]['info']);
                        
                    $object = "SMS au {$craInfo->get('to')} : erreur survenue";
            }
                
            $mail = sendMail(
                $object,
                $html,
                $GLOBALS['_DEV'] ? 
                    ['fredericmevollon@universpneus.com', 'mathieulequin@universpneus.com'] : 
                    array_merge([Config::get('agences')[$this->spaceId][MAIL]], [Config::get('mailing/listBCC')])
                );
            
            $this->logs->put($mail === true ? '--> mail envoye' : '--> erreur : '.$mail);
        }
        else {
            
            $this->logs->put('--> erreur sur API');

            $mail = sendMail(
                'Push-Cra : erreurs de traitement',
                'logs : '.Config::get('logs/link'),
                $GLOBALS['_DEV'] ? 
                    ['fredericmevollon@universpneus.com'] : 
                    [Config::get('mailing/listBCC')]
                );
            
            $this->logs->put($mail === true ? '--> mail ADMIN envoye' : '--> erreur : '.$mail);
        }
    }

    
    private function findOrigin(AutoObject $push, &$cra, &$craInfo) {
        
        $call = new FindCraByIds($this->connection());
        
        $call->sendRequest($push->get('contact_id'));
        
        if ( $call->error() ) {
            
            $this->logs->put($call->message());
            $this->error = true;
        }
        else {
            
            $cra = new AutoObject($call->results()[0]);
// debug($cra);
            
            $date = new \DateTime(date('y-m-d', (int)$cra->get('creationDate')));
            
            $call = new GetSingleCallCra($this->connection());
            
            $call = $call->sendRequest('date', $date->getTimestamp());
            
            if ( $call->error() ) {
                
                $this->logs->put($call->message());
                $this->error = true;
            }
            else {
                
                $listCra = new AutoObject($call->results());
// debug($listCra);        
                
                foreach ( $listCra->get('list') as $single ) {
                    
                    if ( $single['messageId'] == $cra->get('contactId') ) {
                        
                        $craInfo = new AutoObject($single);
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