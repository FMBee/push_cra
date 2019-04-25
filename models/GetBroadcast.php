<?php

class GetBroadcast extends ApiMethod {
    
 
    const API = 'BroadcastWS/getBroadcast';
    
    
    public function sendRequest(string $seek) {
        
        $this->query .= 
            self::API
            .'?authenticate='   .urlencode(json_encode($this->connect))
            .'&broadcastId='    .urlencode($seek);
        
        $this->analyse(file_get_contents($this->query));
            
        return $this;
    }
    
}

/*
array(2) {
  ["success"]=>
  bool(true)
  ["response"]=>
  array(16) {
    ["broadcastName"]=>
    string(22) "Diffusion par mail2SMS"
    ["broadcastId"]=>
    int(116901962)
    ["priority"]=>
    int(1)
    ["startDate"]=>
    float(1556185430446)
    ["stopDate"]=>
    float(1556187230446)
    ["scenarioName"]=>
    string(15) "Mail2SMS_winpro"
    ["scenarioId"]=>
    int(37956)
    ["callPlanningId"]=>
    int(10513)
    ["quotaResult"]=>
    string(0) ""
    ["quota"]=>
    int(0)
    ["callPlanningName"]=>
    string(13) "Planning 24/7"
    ["maxSimultaneousContact"]=>
    int(0)
    ["status"]=>
    string(9) "Terminée"
    ["statusCode"]=>
    string(11) "BR_FINISHED"
    ["broadcastOrigin"]=>
    string(2) "WS"
    ["spreading"]=>
    bool(false)
  }
}
*/  