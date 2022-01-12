<?php 

//Database Class
require_once("Database/DB.php");
//Array that has all the data for the forms
require('Extras/FormBuilderArray.php');

//setting the correct timezone
date_default_timezone_set('America/Dawson_Creek');

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
    DB_Admin::exFile(file_get_contents('Database/sql/Admin.sql'));
    touch('Build/Built');
}
//Functions
//|\|/\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\|/|\

//push output as json
function stouts($message, $type='info'){
    $types = explode(',', str_replace(' ', '', 'info, sucess, error'));
    if(in_array($type, $types)){
        return json_encode([$type=>$message]);
    }else{
        return json_encode(['info'=>$message]);
    }
}
//Gets the comapany DB and Display Pref
function getInfoFromToken($token){
    $DBAdmin = new DB_Admin;
    $loginData = $DBAdmin->query('SELECT DBName, ListDisplayPref FROM
        `LoginAuth` inner join Companies on LoginAuth.CompaniesID = Companies.ID
         WHERE Token = :token', array('token'=>$token));
    if(isset($loginData[0]['DBName'])){
        return $loginData[0];
    }else{
        return array('Error'=>'That token is not conected to company');
    }
}
//Main router for all incoming requests
function InitRouter(){
    //Globals
    global $FormBuilderArray;
    //alowed request types
    $requestTypes = [
        'add',
        'update',
        'info',
        'delete'
    ];
    //Get url without parms
    $full_url = explode('?', $_SERVER['REQUEST_URI']);
    //Split into Array
    $Routes =  explode('/', $full_url[0]);
    //Remove first item of array to account for inital /
    array_shift($Routes);
    //Set method
    $method = $_SERVER['REQUEST_METHOD'];
    //Build file path from url
    if($Routes[0] == 'login'){
        //handle login
        include('Extras/login.php');
    }elseif($Routes[0] == 'token'){
        //handle token checks
        include('Extras/token.php');
    }elseif($Routes[0] == 'logout'){
        //handle logout
        include('Extras/logout.php');
    }elseif(isset($FormBuilderArray['Routes'][$Routes[0]])){
        if(isset($FormBuilderArray['Routes'][$Routes[0]]['view'])){
            $viewFile = "./Views/".$Routes[0].'.php';
            if(is_file($viewFile)){
                include($viewFile);
                exit();
            }
        }
        if($method == 'GET'){
            if(isset($Routes[1]) and (strtolower($Routes[1]) == 'add' or strtolower($Routes[1] == 'info'))){
                getFormStruct($FormBuilderArray['Routes'][$Routes[0]], $Routes[0], $Routes[1]);
            }elseif(isset($Routes[1]) and strtolower($Routes[1]) == 'update' ){
                //Return the data and structure for updating item
                selectUpdateFormItem($FormBuilderArray['Routes'][$Routes[0]], $Routes[0], $Routes[2]);
            }elseif(isset($Routes[1]) and !in_array(strtolower($Routes[1]), $requestTypes)){
                //Handle the individual requests
                selectFormItem($FormBuilderArray['Routes'][$Routes[0]], $Routes[1]);
            }elseif(!isset($Routes[1]) or empty($Routes[1])){
                selectFormData($FormBuilderArray['Routes'][$Routes[0]]);
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
            if(!empty($PostData) and strtolower($Routes[1]) == 'add'){
                insertFormData($PostData, $localArray);
            }elseif(!empty($PostData) and strtolower($Routes[1]) == 'update'){
                updateFormData($PostData, $localArray, $Routes[2]);
            }else{
                echo stouts('No data recieved', 'error');
            }
            
            

        }
    }else{
        echo stouts('That Route Does Not Exist', 'error');
    }
}
//handler updating the db
function updateFormData($formData, $localArray, $ID){
    $DBAdmin = new DB_Admin;
    
    if(!isset($formData['Token'])){
        echo stouts('Please include Login token', 'error');
        exit();
    }
    $data = $DBAdmin->query('SELECT * FROM `LoginAuth` inner join Companies on LoginAuth.CompaniesID = Companies.ID WHERE Token = :token', array('token'=>$formData['Token']));

    if(empty($data)){
        echo stouts('Auth Token has expried or is invalid', 'error');
        exit();
    }
    $DB = new DB($data[0]['DBName']);
    $outArray = [];
    $dataArray = [];
    foreach($localArray['items'] as $items){
        if(isset($formData[$items['name']]) and $formData[$items['name']] != ""){
            $outArray[] = $items['name'];
            $dataArray[$items['name']] =  $formData[$items['name']];
        }
    }
    $final = [];
    foreach($outArray as $out){
        $final[] = $out.'=:'.$out;
    }
    $final = implode(', ', $final);
    $dataArray['ID'] = $ID;

    $dataUpdate = $DB->query('UPDATE '.$localArray['tableName'].' SET '.$final.' WHERE ID=:ID', $dataArray);

    echo stouts('Cow Updated Sucessfully', 'sucess');


}
//form builder for the update system
function selectUpdateFormItem($formArray, $redirectName, $ID){
    $sendData = [];
    if(!isset($_GET['token'])){
        echo stouts('Please include token parm', 'error');
        exit();
    }
    
    $DBNameCheck = getInfoFromToken($_GET['token']);

    if(isset($DBNameCheck['Error'])){
        echo stouts($DBNameCheck['Error'], 'error');
        exit();
    }

    $onlyDisplay = json_decode($DBNameCheck['ListDisplayPref'], true);
    $selectItems = [];
    if($onlyDisplay != null){
        
        foreach($formArray['items'] as $item){
            if(isset($onlyDisplay[$item['name']])){
                $sendData['Info'][$item['name']] = $item['inputLabel'];
                $selectItems[] = $item['name'];
            }
        }
    }else{
        foreach($formArray['items'] as $item){
            $sendData['Info'][$item['name']] = $item['inputLabel'];
            $selectItems[] = $item['name'];
        }
    }
    $selectItems[] = 'ID';
    $selectItems = implode(', ', $selectItems);
    $DB = new DB($DBNameCheck['DBName']);

    $data = $DB->query("SELECT $selectItems from ".$formArray['tableName']." WHERE ID=:ID order By Adate Desc", array('ID'=>$ID));
    if(!isset($data[0]['ID'])){
        echo stouts('The ID is invalid', 'error');
        exit();
    }

    $updateData = $data[0];

    if(isset($_GET['token'])){
        $tokenData = json_decode(getInfoFromToken($_GET['token'])['ListDisplayPref'], true);
    }else{
        $tokenData = null;
    }
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
    $arrayToSend['form']['formTitle'] = 'Update '.$formArray['formDesc'];
    $arrayToSend['form']['callBack'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$redirectName.'/update/'.$ID;
    foreach($formArray['items'] as $items){
        if($tokenData and !$tokenData[$items['name']]){
            continue;
        }
        $itemArray = [];
        if($items['type'] == 'date'){
            $itemArray['defaultValue'] = date('Y-m-d');
        }
        if(isset($items['passwordConfirm'])){
            $arrayToSend['form']['passwordCheck'] = [$items['passwordConfirm'], $items['name']];
        }
        foreach($items as $itemName => $item){
            if(in_array($itemName, $FormPassthroughItems)){
                $itemArray[$itemName] = $item;
            }
        }
        if(!empty($updateData[$items['name']])){
            $itemArray['defaultValue'] = $updateData[$items['name']];
        }
         
        $arrayToSend['form']['fields'][] = $itemArray;
    }
    echo json_encode($arrayToSend); 
}
//get structure for building the add forms
function getFormStruct($formArray, $redirectName, $action){
    if($action == 'add'){
        $redirectName = $redirectName.'/'.$action;
    }
    if(isset($_GET['token'])){
        $tokenData = json_decode(getInfoFromToken($_GET['token'])['ListDisplayPref'], true);
    }else{
        $tokenData = null;
    }
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
    $arrayToSend['form']['formTitle'] = 'Add '.$formArray['formDesc'];
    $arrayToSend['form']['callBack'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$redirectName;
    foreach($formArray['items'] as $items){
        if($tokenData and !$tokenData[$items['name']]){
            continue;
        }
        $itemArray = [];
        if($items['type'] == 'date'){
            $itemArray['defaultValue'] = date('Y-m-d');
        }
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
//get individual info
function selectFormItem($localArray, $ID){
    $sendData = [];
    if(!isset($_GET['token'])){
        echo stouts('Please include token parm', 'error');
        exit();
    }
    
    $DBNameCheck = getInfoFromToken($_GET['token']);

    if(isset($DBNameCheck['Error'])){
        echo stouts($DBNameCheck['Error'], 'error');
        exit();
    }

    $onlyDisplay = json_decode($DBNameCheck['ListDisplayPref'], true);
    $selectItems = [];
    if($onlyDisplay != null){
        
        foreach($localArray['items'] as $item){
            if(isset($onlyDisplay[$item['name']])){
                $sendData['Info'][$item['name']] = $item['inputLabel'];
                $selectItems[] = $item['name'];
            }
        }
    }else{
        foreach($localArray['items'] as $item){
            $sendData['Info'][$item['name']] = $item['inputLabel'];
            $selectItems[] = $item['name'];
        }
    }
    $selectItems[] = 'ID';
    $selectItems = implode(', ', $selectItems);
    
    $DB = new DB($DBNameCheck['DBName']);

    $data = $DB->query("SELECT $selectItems from ".$localArray['tableName']." WHERE ID=:ID order By Adate Desc", array('ID'=>$ID));
    if(isset($data[0]['ID'])){
        $sendData['Data'] = $data;
        echo json_encode($sendData);
    }else{
        echo stouts('The ID is invalid', 'error');
    }
    
}
//get bulk data
function selectFormData($localArray){
    $sendData = [];
    if(!isset($_GET['token'])){
        echo stouts('Please include token pram', 'error');
        exit();
    }
    
    $DBNameCheck = getInfoFromToken($_GET['token']);

    if(isset($DBNameCheck['Error'])){
        echo stouts($DBNameCheck['Error'], 'error');
        exit();
    }

    $onlyDisplay = json_decode($DBNameCheck['ListDisplayPref'], true);
    $selectItems = [];
    foreach($localArray['items'] as $item){
        if($onlyDisplay != null){
            if($onlyDisplay[$item['name']]){
                $sendData['Info'][$item['name']] = $item['inputLabel'];
                $selectItems[] = $item['name'];
            }
        }else{
            $sendData['Info'][$item['name']] = $item['inputLabel'];
                $selectItems[] = $item['name'];
        }
        
    }
    $selectItems[] = 'ID';
    $selectItems = implode(', ', $selectItems);

    $DB = new DB($DBNameCheck['DBName']);

    $data = $DB->query("SELECT $selectItems from ".$localArray['tableName']." order By Adate Desc ");
    $sendData['Data'] = $data;
    echo json_encode($sendData);
    
    
}
//insert form data
function insertFormData($RecivedFormData, $localArray){
    $DBAdmin = new DB_Admin;
   
    if(isset($localArray['tokenAuth']) and isset($localArray['dbCreate'])){
        if(!isset($RecivedFormData['Token'])){
            echo stouts('Please include auth token', 'error');
            exit();
        }
        $data = $DBAdmin->query('SELECT Token, Expire from LoginAuth WHERE Token = :token', array('token'=>$RecivedFormData['Token']));
        
        if(empty($data)){
            echo stouts('Auth Token has expried or is invalid', 'error');
            exit();
        }
    }elseif(isset($localArray['loginAuth'])){
        if(!isset($RecivedFormData['Token'])){
            echo stouts('Please include Login token', 'error');
            exit();
        }
        $loginData = $DBAdmin->query('SELECT * FROM `LoginAuth` inner join Companies on LoginAuth.CompaniesID = Companies.ID WHERE Token = :token', array('token'=>$RecivedFormData['Token']));
        if(!isset($loginData[0]['DBName'])){
            echo stouts('Your Token is not linked to a company', 'error');
            exit();
        }
    }
    
    if(isset($localArray['dbCreate'])){
        $DB = $DBAdmin;
    }else{
        $DB = new DB($loginData[0]['DBName']);
    }
    
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
                    $check = $DB->query("SELECT $itemKey From $table WHERE $itemKey=:$itemKey", array($itemKey=>$item));
                    if(!empty($check)){
                        echo stouts("This $itemKey Already Exists", 'error');
                        exit();
                    }                    
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
    }while(!empty($DB->query("SELECT ID from ".$localArray['tableName']." WHERE ID = '$UUID'")));
    $insertStringArray[] = 'ID';
    $pdoDataArray['ID'] = $UUID;
    if(isset($localArray['dbCreate'])){
        do{
            $UUID = bin2hex(random_bytes(8));
        }while(!empty($DB->query("SELECT ID from ".$localArray['tableName']." WHERE ID='$UUID'")));
        
        $name = str_replace("'", '', str_replace(' ', '', ucwords($pdoDataArray[$localArray['dbCreate']])));
        $DBName = 'Hoves$2$'.$name.'$'.$UUID;
        $pdoDataArray['ID'] = $UUID;
        $pdoDataArray['DBName'] = $DBName;
        $insertStringArray[] = 'DBName';
        $DB->mkDB($DBName);
        $DB_Local = new DB($DBName);
        $dbBuildData = 'Database/sql/'.$localArray['tableName'].'.sql';
        if(is_file($dbBuildData)){
            $DB_Local->exFile(file_get_contents($dbBuildData));
        }
    }

    if(isset($localArray['secondTable'])){
        do{
            $secUUID = bin2hex(random_bytes(8));
        }while(!empty($DB->query("SELECT ID from ".$localArray['secondTable']." WHERE ID='$secUUID'")));
        
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
    
    if(isset($localArray['tokenAuth'])){
        $data = $DB->query('DELETE from '.$localArray['tokenAuth'].' WHERE Token = :token', array('token'=>$RecivedFormData['Token']));
    }

    echo stouts($localArray['Sucess'], 'sucess');
    
}

//init the router
InitRouter();