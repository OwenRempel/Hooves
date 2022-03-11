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

function getEntries($DB, $formData, $groupID ){
    $groupData = $DB->query('SELECT data from '.$formData['tableName'].' WHERE ID=:id', array('id'=>$groupID));
    echo json_encode($groupData);
}


function addEntry($DB, $formData, $groupID, $entryID){
    $DataArray = [];
    $groupData = $DB->query('SELECT data from '.$formData['tableName'].' WHERE ID=:id', array('id'=>$groupID));
    $entryData = $DB->query('SELECT ID from '.$formData['entriesTarget'].' WHERE ID=:id', array('id'=>$entryID));
    if(!isset($groupData[0])){
        http_response_code(404);
        echo stouts('That Group Dosen\'t Exist', 'error');
        exit();
    }else{
        $groupData = $groupData[0];
    }

    if(!isset($entryData[0]['ID'])){
        http_response_code(404);
        echo stouts('That Entry Dosen\'t Exist', 'error');
        exit();
    }

    if($groupData['data']){
        $DataArray = json_decode($groupData['data'], 1);
    }

    if(in_array($entryID, $DataArray)){
        echo stouts('Entry already in Group', 'success');
        exit();
    }
    $DataArray[] = $entryID;
    $sendData = json_encode($DataArray);
    $DB->query('Update '.$formData['tableName'].' SET data=:group WHERE ID=:id', array('group'=>$sendData, 'id'=>$groupID));
    $DB->query('Update '.$formData['entriesTarget'].' SET '.$formData['entriesLink'].'=:group WHERE ID=:id', array('group'=>$groupID, 'id'=>$entryID));
    echo stouts('Entry added to Group', 'success');
    exit();
}

function removeEntry($DB, $formData, $groupID, $entryID){
    $DataArray = [];
    $groupData = $DB->query('SELECT data from '.$formData['tableName'].' WHERE ID=:id', array('id'=>$groupID));
    $entryData = $DB->query('SELECT ID from '.$formData['entriesTarget'].' WHERE ID=:id', array('id'=>$entryID));
    if(!isset($groupData[0])){
        http_response_code(404);
        echo stouts('That Group Dosen\'t Exist', 'error');
        exit();
    }else{
        $groupData = $groupData[0];
    }

    if(!isset($entryData[0]['ID'])){
        http_response_code(404);
        echo stouts('That Entry Dosen\'t Exist', 'error');
        exit();
    }

    if($groupData['data']){
        $DataArray = json_decode($groupData['data'], 1);
    }

    if(!in_array($entryID, $DataArray)){
        echo stouts('Entry is not in Group', 'success');
        exit();
    }
    
    $DataArray = array_filter($DataArray, fn($value) => $value !== $entryID);

    $sendData = json_encode($DataArray);
    $DB->query('Update '.$formData['tableName'].' SET data=:group WHERE ID=:id', array('group'=>$sendData, 'id'=>$groupID));
    $DB->query('Update '.$formData['entriesTarget'].' SET '.$formData['entriesLink'].'=null WHERE ID=:id', array('id'=>$entryID));
    echo stouts('Entry removed from Group', 'success');
    exit();
}


$groupFormData = [
    'loginAuth'=>true,
    'formDesc'=>'Group',
    'formName'=>'GroupMod',
    'tableName'=>'GroupData',
    'success'=>'Group successfully created!',
    'entriesTarget'=>'Cattle',
    'entriesLink'=>'GroupId',
    'items'=>[
        [
            'name'=>'GroupName',
            'typeName'=>'FormInput',
            'type'=>'text',
            'inputLabel'=>'Group Name',
            'unique'=>true
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
        if($Routes[1] == 'info' and !isset($Routes[2])){
            http_response_code(200);
            getFormStruct($groupFormData, 'group');
        }elseif($Routes[1] == 'info' and isset($Routes[2])){
            selectUpdateFormItem($groupFormData, $Routes[0], $Routes[2]);
        }elseif($Routes[1] == 'entries' and isset($Routes[2])){
            getEntries($DB, $groupFormData, $Routes[2]);
        }else{
            selectFormData($groupFormData);
        }
        break;
    case 'POST':
        if($Routes[2] == 'entries'){
            if(isset($Routes[3])){
                if(!isset($PostData['entryID'])){
                    echo stouts('Please include an ID you wish to add', 'error');
                    exit();
                }
                switch ($Routes[3]) {
                    case 'add':
                        addEntry($DB, $groupFormData, $Routes[1], $PostData['entryID']);
                        break;
                    case 'remove':
                        removeEntry($DB, $groupFormData, $Routes[1], $PostData['entryID']);
                        break;
                    default:
                        http_response_code(404);
                        echo stouts('Please Choose a valid action', 'error');
                        break;
                }
            }else{
                http_response_code(404);
                echo stouts('This route is not valid', 'error');
            }
        }else{
            insertFormData($PostData, $groupFormData, $Routes);
        }
        break;
    case 'PUT':
        updateFormData($PostData, $groupFormData, $Routes[1]);
        break;
    case 'DELETE':
        deleteItem($groupFormData, $Routes[1]);
        break;
    default:
        http_response_code(405);
        echo stouts('That Method is not valid', 'error');
        break;
}
