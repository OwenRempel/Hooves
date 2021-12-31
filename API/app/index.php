<?php 
//Database Class
require_once("Database/DB.php");
//Array that has all the data for the forms
require('Extras/FormBuilderArray.php');

//Cors Headers
//|\|/\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\

// Allow from any origin TODO:Finalize for Production
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 60000"); //set cache for a long time TODO: change this before production

//Setup
//|\|/\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\
//Request method OPTIONS
if($_SERVER["REQUEST_METHOD"] == "OPTIONS"){
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}
//Check to see if Setup complete
if(!is_file('Build/Built')){
    DB_Admin::mkDB('HovesAdmin');
    DB_Admin::exFile(file_get_contents('Database/sql/admin.sql'));
    touch('Build/Built');
}
//Functions
//|\|/\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\
function stouts($message, $type='info'){
    $types = explode(',', str_replace(' ', '', 'info, sucess, error'));
    if(in_array($type, $types)){
        return json_encode([$type=>$message]);
    }else{
        return json_encode(['info'=>$message]);
    }
}
function InitRouter(){
    //Globals
    global $FormBuilderArray;
    //Get url without parms
    $full_url = explode('?', $_SERVER['REQUEST_URI']);
    //Split into Array
    $Routes =  explode('/', $full_url[0]);
    //Remove first item of array to account for inital /
    array_shift($Routes);
    //Set method
    $method = $_SERVER['REQUEST_METHOD'];
    //Build file path from url
    if(isset($FormBuilderArray['Routes'][$Routes[0]])){
        if(isset($FormBuilderArray['Routes'][$Routes[0]]['view'])){
            $viewFile = "./Views/".$Routes[0].'.php';
            if(is_file($viewFile)){
                include($viewFile);
                exit();
            }
        }
        if($method == 'GET'){
            if(isset($Routes[1]) and (strtolower($Routes[1]) == 'add' or strtolower($Routes[1] == 'info'))){
                getFormStruct($FormBuilderArray['Routes'][$Routes[0]], $Routes[0]);
            }elseif(!isset($Routes[1])){
                echo stouts('TODO:This will list all of the '.$Routes[0], 'info');
            }else{
                echo stouts('The action you have entered is not alowed on a GET Request', 'error');
            }
        }elseif($method == "POST"){
            $localArray = $FormBuilderArray['Routes'][$Routes[0]];
            $PostInput = json_decode(file_get_contents('php://input'), 1);
            //This is the check to see if the api should use $_POST or php://input
            if(isset($_POST[$localArray['formName']])){
                $PostData = $_POST;
            }elseif(isset($PostInput[$localArray['formName']])){
                $PostData = $PostInput;
            }else{
                echo stouts('There was an error processing your post request', 'error');
                exit();
            }
            //This is where the receved form is entered into the database
            if(!empty($PostData)){
                insertFormData($PostData, $localArray);
            }else{
                echo stouts('No data recieved', 'error');
            }
            
            

        }
    }else{
        echo stouts('That Route Does Not Exist', 'error');
    }
}
function getFormStruct($formArray, $redirectName){
    $FormPassthroughItems = [
        'name',
        'type',
        'typeName',
        'checkboxLabel',
        'required',
        'selectLabel',
        'textareaLabel', 
        'options',
        'inputLabel',
        'placeholder',
        'checkboxTitle',
        'password_check'
    ];
    $arrayToSend = [];
    $arrayToSend['form']['formName'] = $formArray['formName'];
    $arrayToSend['form']['formTitle'] = $formArray['formTitle'];
    $arrayToSend['form']['callBack'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/'.$redirectName;
    foreach($formArray['items'] as $items){
        $itemArray = [];
        if(isset($items['passwordConfirm'])){
            $arrayToSend['form']['passwordCheck'] = [$items['passwordConfirm'], $items['name']];
        }
        foreach($items as $itemName => $item){
            if(in_array($itemName, $FormPassthroughItems)){
                $itemArray[$itemName] = $item;
            }
        }
        $arrayToSend['form']['fields'][] = $itemArray;
    }
    echo json_encode($arrayToSend);
}
function insertFormData($RecivedFormData, $localArray){
    $DB = new DB_Admin;
    $insertStringArray = [];
    $pdoDataArray = [];
    if(isset($localArray['secondTable'])){
        $secInsertStringArray = [];
        $secPdoDataArray = [];
    }
    foreach($RecivedFormData as $itemKey => $item){
        foreach($localArray['items'] as $formItem){
            if($itemKey == $formItem['name']){
                if(isset($formItem['passwordConfirm'])){
                    continue;
                }
                if($formItem['type'] == 'password'){
                    $item = password_hash($item, PASSWORD_BCRYPT);
                }
                if(isset($formItem['unique']) and $formItem['unique'] == true){
                    $table = (isset($localArray['secondTable']) ? $localArray['secondTable'] : $localArray['tableName'] );
                    
                }
                if(isset($formItem['secondTable']) and $formItem['secondTable'] == true){
                    $secPdoDataArray[$itemKey] = $item; 
                    $secInsertStringArray[] = $itemKey;
                }else{
                    $pdoDataArray[$itemKey] = $item; 
                    $insertStringArray[] = $itemKey;
                }
                continue;
            }
        }
    }
    //TODO:here is where we will check the uuid to make sure it is unique
    do{
        $UUID = bin2hex(random_bytes(24));
    }while(false);
    
    if(isset($localArray['tokenAuth'])){
        if(!isset($RecivedFormData['Token'])){
            echo stouts('Please include auth token', 'error');
            exit();
        }
        
        $data = $DB->query('SELECT Token, Expire from '.$localArray['tokenAuth'].' WHERE Token = :token', array('token'=>$RecivedFormData['Token']));
        if(empty($data)){
            echo stouts('Auth Token has expried or is invalid', 'error');
            exit();
        }
    }
    if(isset($localArray['dbCreate'])){
        $UUID = bin2hex(random_bytes(8));
        $name = str_replace(' ', '', ucwords($pdoDataArray[$localArray['dbCreate']]));
        $DBName = $name.'$'.$UUID;
        $pdoDataArray['ID'] = $UUID;
        $pdoDataArray['DBName'] = $DBName;
        $insertStringArray[] = 'ID';
        $insertStringArray[] = 'DBName';
        $DB->mkDB($DBName);
    }

    if(isset($localArray['secondTable'])){
        $secUUID = bin2hex(random_bytes(24));
        $secInsertStringArray[] = 'ID';
        $secPdoDataArray['ID'] = $secUUID;
        $secPdoDataArray[$localArray['tableName'].'ID'] = $UUID;
        $secInsertStringArray[] = $localArray['tableName'].'ID';
        $secValues = implode(', ',$secInsertStringArray);
        $secDataValues =':'.implode(', :',$secInsertStringArray);
        $DB->query("INSERT INTO ".$localArray['secondTable']." ($secValues) VALUES ($secDataValues)", $secPdoDataArray);    
    }
    
   
    $values = implode(', ',$insertStringArray);
    $dataValues =':'.implode(', :',$insertStringArray);

    $DB->query("INSERT INTO ".$localArray['tableName']." ($values) VALUES ($dataValues)", $pdoDataArray);
   
    echo stouts($localArray['Sucess'], 'sucess');
    
}


InitRouter();