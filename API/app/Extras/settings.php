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
$feedlot = $DB_Admin->query('SELECT Feedlot from Companies WHERE DBName = :db', array('db'=>$AuthData['DBName']));

$BuildItems = $FormBuilderArray['Routes']['cattle']['items'];

if(intval($feedlot[0]['Feedlot']) === 0){
    $BuildItems = $FormBuilderArray['Routes']['calves']['items'];
}

function addLabels($arr){
    Global $FormBuilderArray;
    $items = $FormBuilderArray['Routes']['cattle']['items'];
    $out = [];
    foreach($items as $item){
        
        if(isset($arr[$item['name']])){
            $out[$item['name']] = [
                'value'=>$arr[$item['name']],
                'name'=>(isset($item['inputLabel']) ? $item['inputLabel'] : $item['name'])
            ];
        }
    }
    return $out;
}

if($Routes[1] == 'view-items'){
    $da = $DB_Admin->query('SELECT ListDisplayPref FROM Companies WHERE DBName=:db', array('db'=>$AuthData['DBName']));
   
    if($method == 'GET'){
        if($Routes[2] == 'info'){
            $list = null;
            if(isset($da[0]['ListDisplayPref'])){
                $list = json_decode($da[0]['ListDisplayPref'], 1);
            }
            $arrayOut = [];
            //TODO: This will have to be updated to allow for weights and other items
            foreach($BuildItems as $item){
                $name = $item['name'];
                if(isset($list[$name])){
                    $arrayOut[$name] = $list[$name];
                }else{
                    $arrayOut[$name] = true;
                }
            }
            echo json_encode(addLabels($arrayOut));
        }else{
            http_response_code(404);
            echo stouts('That view dosen\'t Exist', 'error');
            exit();
        }
    }elseif($method == 'POST'){
        $build = [];
        foreach($BuildItems as $item){
            $name = $item['name'];
            if(isset($PostData[$name])){
                $build[$name] = $PostData[$name];
            }
        }
       
        $DB_Admin->query('UPDATE Companies SET ListDisplayPref=:di WHERE DBName=:db', array('di'=>json_encode($build),'db'=>$AuthData['DBName']));    
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