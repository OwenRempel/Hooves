<?php

echo 'Users';
exit();

//TODO: Lots of work here
// Resources $localarray, $PostData, $Routes, $FormBuilderArray

$PHPinput = file_get_contents('php://input');
$PostInput = json_decode($PHPinput, 1);
parse_str($PHPinput, $_PUT);
//echo json_encode($PostInput);
//This is the check to see if the api should use $_POST or php://input
if($method == 'POST' or $method == 'PUT'){
    if(isset($_POST['UserMod'])){
        $PostData = $_POST;
    }elseif(isset($_PUT['UserMod'])){
        $PostData = $_PUT;
    }elseif(isset($PostInput['UserMod'])){
        $PostData = $PostInput;
    }else{
        http_response_code(400);
        echo stouts('No data Received', 'error');
        exit();
    }
}



//this is where the auth header is checked
$AuthData = checkAuth();


$DB = new DB_Admin;

function getEntries($DB, $formData, $groupID, $return = false ){

}
    


$groupFormData = [
    'formTitle'=>'Add Company',
    'formName'=>'CompanyAddItem',
    'items'=>[
        [
            'name'=>'UserEmail',
            'typeName'=>'FormInput',
            'unique'=>True,
            'type'=>'text',
            'inputLabel'=>'User Email',
            'secondTable'=>True
            
        ],
        [
            'name'=>'UserPassword',
            'typeName'=>'FormInput',
            'type'=>'password',
            'inputLabel'=>'Password',
            'secondTable'=>True                    
        ],
        [
            'name'=>'UserPassword-confirm',
            'typeName'=>'FormInput',
            'passwordConfirm'=>'UserPassword',
            'type'=>'password',
            'inputLabel'=>'Confirm Password'
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
        }elseif($Routes[2] == 'entries'){
            getEntries($DB, $groupFormData, $Routes[1]);
        }else{
            selectFormData($groupFormData);
        }
        break;
    case 'POST':
        if($Routes[2] == 'entries'){
            if(isset($Routes[3])){
                if(!isset($PostData['entryID'])){
                    echo stouts('Please include an ID you wish to alter', 'error');
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
$out = [
    
];