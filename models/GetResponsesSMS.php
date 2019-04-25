<?php

class GesResponsesSMS extends ApiMethod {
    
 
    const API = 'SupervisionWS/getResponsesSMS';
    
    
    public function sendRequest(string $dateD, string $dateF) {
        
        $this->query .= 
            self::API
            .'?authenticate='   .urlencode(json_encode($this->connect))
            .'&stopOnly=false'
            .'&beginDate='      .$seek
            .'&endDate='        .$seek;
        
        $this->analyse(file_get_contents($this->query));
            
        return $this;
    }
    
}

/*
FindCraByIds
Array
(
    [success] => 1
    [response] => Array
    (
        [0] => Array
        (
            [contactId] => 2482508840
            [spaceId] => 156925
            [firstName] => Contact unitaire pour:SMS
            [lastName] => 3b05daaa-74cc-422f-910e-73058f3d3c27
            [externalReference] => id001
            [active] =>
            [creationDate] => 1555075305710
            [phoneNumber1] => 0617365731
            [broadcastId] => 116122513
            [callAttempts] => 1
            [callDate] => 1555075326000
            [statusLastChange] => 1555075333000
            [callAdress] => +33617365731
            [callResult] => Reçu
            [callResultCode] => CRA_SMS_RECEIVED
            [status] => DONE
            [callResponse] => rep4
            [callDetail] => 1 partie(s)
            [quotaOccurs] => 0
        )
    )
)
*/  