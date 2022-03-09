<?php

// Resources $localarray, $PostData, $Routes, $FormBuilderArray

$PHPinput = file_get_contents('php://input');
$PostInput = json_decode($PHPinput, 1);
parse_str($PHPinput, $_PUT);
//echo json_encode($PostInput);
//This is the check to see if the api should use $_POST or php://input
if($method == 'POST' or $method == 'PUT'){
    if(isset($_POST['GroupMod'])){
        $PostData = $_POST;
    }elseif(isset($_PUT['GroupMod'])){
        $PostData = $_PUT;
    }elseif(isset($PostInput['GroupMod'])){
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

$groupFormData = [
    'loginAuth'=>true,
    'formDesc'=>'Group',
    'formName'=>'GroupMod',
    'tableName'=>'GroupData',
    'success'=>'Group successfully created!',
    'items'=>[
        [
            'name'=>'GroupName',
            'typeName'=>'FormInput',
            'type'=>'text',
            'inputLabel'=>'Group Name',
            
        ],
        [
            'name'=>'Pen',
            'typeName'=>'FormSelect',
            'inputLabel'=>'Pen',
            'OptionsLoad'=>['Pens', 'Name'],
            'noEdit'=>true
        ]
    ]
    
];

switch ($method) {
    case 'GET':
        if($Routes[1] == 'info'){
            http_response_code(200);
            getFormStruct($groupFormData, 'group');
        }else{
            selectFormData($groupFormData);
        }
        break;
    case 'POST':
        insertFormData($PostData, $groupFormData, $Routes);
        break;
    default:
        http_response_code(405);
        echo stouts('That Method is not valid', 'error');
        break;
}