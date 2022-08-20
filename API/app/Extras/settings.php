<?php

$PHPinput = file_get_contents('php://input');
$PostInput = json_decode($PHPinput, 1);
parse_str($PHPinput, $_PUT);

//This is the check to see if the api should use $_POST or php://input
if($method == 'POST' or $method == 'PUT'){
    if(isset($_POST['SettingsMod'])){
        $PostData = $_POST;
    }elseif(isset($_PUT['SettingsMod'])){
        $PostData = $_PUT;
    }elseif(isset($PostInput['SettingsMod'])){
        $PostData = $PostInput;
    }else{
        http_response_code(400);
        echo stouts('No data Received', 'error');
        exit();
    }
}
//this is where the auth header is checked
$AuthData = checkAuth();

$DB = new DB($AuthData['DBName']);
$DB_Admin = new DB_Admin;
$CompData = $DB_Admin->query('SELECT ListDisplayPref, Feedlot, DBName from Companies WHERE DBName = :db', array('db'=>$AuthData['DBName']));





function addLabels($arr, $BuildItems){
    
}
function parseDisplayPref($CompData, $values = false){
    Global $FormBuilderArray;

    $BuildItems = $FormBuilderArray['Routes']['cattle']['items'];

    if(intval($CompData[0]['Feedlot']) === 0){
        $BuildItems = $FormBuilderArray['Routes']['calves']['items'];
    }
    $list = null;
    if(isset($CompData[0]['ListDisplayPref'])){
        $list = json_decode($CompData[0]['ListDisplayPref'], 1);
    }
    $arrayOut = [];
    foreach($BuildItems as $item){
        $name = $item['name'];
        if(isset($list[$name])){
            $arrayOut[$name] = $list[$name];
        }else{
            $arrayOut[$name] = true;
        }
    }
    if(!$values){
        $out = [];
        foreach($BuildItems as $item){
            
            if(isset($arrayOut[$item['name']])){
                $out[$item['name']] = [
                    'value'=>$arrayOut[$item['name']],
                    'name'=>(isset($item['inputLabel']) ? $item['inputLabel'] : $item['name'])
                ];
            }
        }
        return $out;
    }else{
        return $arrayOut;
    }
    
}
function updateDisplayPref($CompData, $PostData){
    Global $FormBuilderArray;
    

    $BuildItems = $FormBuilderArray['Routes']['cattle']['items'];

    if(intval($CompData[0]['Feedlot']) === 0){
        $BuildItems = $FormBuilderArray['Routes']['calves']['items'];
    }
    $build = [];
    foreach($BuildItems as $item){
        $name = $item['name'];
        if(isset($PostData[$name])){
            $build[$name] = $PostData[$name];
        }
    }

    $DB_Admin = new DB_Admin;
    $DB_Admin->query('UPDATE Companies SET ListDisplayPref=:di WHERE DBName=:db', array('di'=>json_encode($build),'db'=>$CompData[0]['DBName']));    
        


}


if($Routes[1] == 'view-items'){
   
    if($method == 'GET'){
        if($Routes[2] == 'info'){
            echo json_encode(parseDisplayPref($CompData));
        }else{
            
            http_response_code(404);
            echo stouts('That view dosen\'t Exist', 'error');
            exit();
        }
    }elseif($method == 'POST'){
        updateDisplayPref($CompData, $PostData);
        http_response_code(200);
        echo stouts('View Items Updated', 'success');
        exit();
    }
    
}elseif($Routes[1] == 'feedlot-set'){
    if($method == 'POST'){
        if(!isset($PostData['Feedlot'])){
            http_response_code(404);
            echo stouts('Please include a Feedlot value in your body', 'error');
            exit();
        } 
        if($PostData['Feedlot'] == 0 or $PostData['Feedlot'] == 1){
            $DB_Admin->query('UPDATE Companies SET Feedlot=:feed WHERE DBName=:db', array('feed'=>$PostData['Feedlot'],'db'=>$AuthData['DBName']));
            $CompData = $DB_Admin->query('SELECT ListDisplayPref, Feedlot, DBName from Companies WHERE DBName = :db', array('db'=>$AuthData['DBName']));
            updateDisplayPref($CompData, parseDisplayPref($CompData, true));
            http_response_code(200);
            echo stouts('Feedlot Status Updated Successfully', 'success');
            exit();
        }else{
            http_response_code(403);
            echo stouts('Invalid value please use a 1 or a 0', 'error');
            exit();
        }
       
    }else{
        http_response_code(401);
        echo stouts('You can only POST to this route', 'error');
        exit();
    }
}else{
    http_response_code(404);
    echo stouts('That view dosen\'t Exist', 'error');
    exit();
}