<?php

// Resources $localarray, $PostData, $Routes, $FormBuilderArray

$PHPinput = file_get_contents('php://input');
$PostInput = json_decode($PHPinput, 1);
parse_str($PHPinput, $_PUT);
//echo json_encode($PostInput);
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



if(!isset($_GET['token']) and !isset($PostData['Token'])){
    http_response_code(401);
    echo stouts('Please include token parm', 'error');
    exit();
}
if(isset($_GET['token'])){
    $userData = getInfoFromToken($_GET['token']);
}else{
    $userData = getInfoFromToken($PostData['Token']);
}


if(isset($userData['Error'])){
    echo stouts($userData['Error'], 'error');
    exit();
}


$DB = new DB($userData['DBName']);
$DB_Admin = new DB_Admin;

$BuildItems = $FormBuilderArray['Routes']['cattle']['items'];

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
    $da = $DB_Admin->query('SELECT ListDisplayPref FROM Companies WHERE DBName=:db', array('db'=>$userData['DBName']));
   
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
       
        $DB_Admin->query('UPDATE Companies SET ListDisplayPref=:di WHERE DBName=:db', array('di'=>json_encode($build),'db'=>$userData['DBName']));    
        http_response_code(200);
        echo stouts('View Items Updated', 'success');
        exit();
    }
    

}else{
    http_response_code(404);
    echo stouts('That view dosen\'t Exist', 'error');
    exit();
}