<?php

class GetResponsesSMS extends ApiMethod {
    
 
    const API = 'SupervisionWS/getResponsesSMS';
    
    
    public function sendRequest(string $dateD, string $dateF) {
        
        $this->query .= 
            self::API
            .'?authenticate='   .urlencode(json_encode($this->connect))
            .'&stopOnly=false'
            .'&beginDate='      .$dateD
            .'&endDate='        .$dateF;
debug($this->query);        
        
        $this->analyse(file_get_contents($this->query));
            
        return $this;
    }
    
}

/*
GetResponsesSMS
Array
(
    [success] => 1
    [response] => Array
    (
      array(2) {
        ["list"]=>
        array(2) {
          [0]=>
          array(10) {
            ["contactId"]=>
            float(2499559488)
            ["spaceId"]=>
            int(156907)
            ["firstName"]=>
            string(25) "Contact unitaire pour:SMS"
            ["lastName"]=>
            string(36) "b40db962-fcd9-4360-a27e-7aeff2e5d8cb"
            ["active"]=>
            bool(false)
            ["broadcastId"]=>
            int(116881427)
            ["callDate"]=>
            float(1556174577000)
            ["callAdress"]=>
            string(12) "+33617365731"
            ["callResponse"]=>
            string(8) "rep 25.1"
            ["quotaOccurs"]=>
            int(0)
          }
          [1]=>
          array(10) {
            ["contactId"]=>
            float(2499593502)
            ["spaceId"]=>
            int(156907)
            ["firstName"]=>
            string(25) "Contact unitaire pour:SMS"
            ["lastName"]=>
            string(36) "b663109f-cf87-4e94-9173-be56a5e681b3"
            ["active"]=>
            bool(false)
            ["broadcastId"]=>
            int(116881427)
            ["callDate"]=>
            float(1556176152000)
            ["callAdress"]=>
            string(12) "+33617365731"
            ["callResponse"]=>
            string(8) "rep 25.2"
            ["quotaOccurs"]=>
            int(0)
          }
    ["total"]=>
    int(2)
    )
)
*/  