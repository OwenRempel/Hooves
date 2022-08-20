<?php

function weightUpdator($table, $ID, $DB){
    
    $data = $DB->query("SELECT CowWeight, WeightDate FROM Weight WHERE CowID=:id Order by WeightDate", array('id'=>$ID));
    $len = count($data);

    $sqlData = array(
        'LastWeight'=>$data[$len - 1]['CowWeight'],
        'DateWeight'=>$data[$len - 1]['WeightDate'],
        'FirstWeight' => $data[0]['CowWeight'],
        'FirstDate' => $data[0]['WeightDate']
    );
    if($len > 2){
        $sqlData['SecondLastWeight'] = $data[$len - 2]['CowWeight'];
        $sqlData['SecondLastDate'] = $data[$len - 2]['WeightDate'];
    }else{
        $sqlData['SecondLastWeight'] = $data[$len - 1]['CowWeight'];
        $sqlData['SecondLastDate'] = $data[$len - 1]['WeightDate'];
    }
    $sqlStringData = array_keys($sqlData);


    $sqlString = [];
    foreach($sqlStringData as $row){
        $sqlString[] = $row.'=:'.$row;
    }
    $sqlString = implode(', ', $sqlString);

    $sqlData['ID'] = $ID;

    $DB->query('UPDATE '.$table.' set '.$sqlString.' WHERE ID=:ID', $sqlData);

}