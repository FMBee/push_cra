<?php

    error_reporting(E_ALL);

    $dir = glob('done/push_*');
    
    echo "
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<style>
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}
        
.active, .accordion:hover {
  background-color: #ccc;
}
        
.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
</style>
</head>
<body>
  <button onClick='showAll();'>&nbsp;+&nbsp;</button>
  <button onClick='showNone();'>&nbsp;-&nbsp;</button>
";
    if ( empty($dir) )  echo "Aucun fichier à lister<br>";
    
    foreach( $dir as $file ) {
        
        $input = json_decode(
            file_get_contents($file),
            true
            );
        // if ( is_null($input) )      echo json_last_error(), json_last_error_msg();
        
        echo "<button class='accordion'>{$file}</button>";
        echo "<div class='panel'><pre>";
        echo print_r($input, true);
        echo "</pre></div>";
    }
    
    echo "
<script>

var acc = document.getElementsByClassName('accordion');
var i;
        
for (i = 0; i < acc.length; i++) {

  acc[i].addEventListener('click', function() {

    this.classList.toggle('active');
    var panel = this.nextElementSibling;

    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + 'px';
    }
  });
}

function showAll() {

    var acc = document.getElementsByClassName('accordion');
    var i;
            
    for (i = 0; i < acc.length; i++) {

        var panel = acc[i].nextElementSibling;
        panel.style.maxHeight = panel.scrollHeight + 'px';
    }
}

function showNone() {

    var acc = document.getElementsByClassName('accordion');
    var i;
            
    for (i = 0; i < acc.length; i++) {

        var panel = acc[i].nextElementSibling;
        panel.style.maxHeight = null;
    }
}

</script>
        
</body>
</html>
";


/*
 
Array
(
    [status_report] => Array
        (
            [username] => 9100120861
            [sms] => Array
                (
                    [0] => Array
                        (
                            [to] => +33608771970
                            [date] => 2019-03-28T09:42:47Z
                            [call_id] => 10220468740311
                            [broadcast_id] => 115167023
                            [contact_id] => 2453821632
                            [ref_externe] => 
                            [space_id] => 156925
                            [status_list] => Array
                                (
                                    [0] => Array
                                        (
                                            [date] => 2019-03-28T09:42:46Z
                                            [type] => SENT
                                            [info] => submitted with sender Vulco
                                        )

                                    [1] => Array
                                        (
                                            [date] => 2019-03-28T09:42:47Z
                                            [type] => RECEIVED
                                        )

                                )

                            [status] => RECEIVED
                        )

                )

        )

)
 
 */