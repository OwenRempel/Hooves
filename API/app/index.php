<?php 

//Database Class
require_once("Database/DB.php");
//Array that has all the data for the forms
require('Extras/FormBuilderArray.php');
require('Extras/statFuncs.php');
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

$ApacheHeaders = apache_request_headers();

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
    $types = explode(',', str_replace(' ', '', 'info, success, error'));
    if(in_array($type, $types)){
        return json_encode([$type=>$message]);
    }else{
        return json_encode(['info'=>$message]);
    }
}
//Gets the company DB and Display Pref
function getInfoFromToken($token){
    if(!$token){
        http_response_code(404);
        return array('Error'=>'No Token included');
    }
    $DBAdmin = new DB_Admin;
    $loginData = $DBAdmin->query('SELECT DBName, ListDisplayPref FROM
        `LoginAuth` inner join Companies on LoginAuth.CompaniesID = Companies.ID
         WHERE Token = :token', array('token'=>$token));
    if(isset($loginData[0]['DBName'])){
        return $loginData[0];
    }else{
        http_response_code(404);
        return array('Error'=>'That token is not connected to company');
    }
}
//Get data from bearer token
//Gets the company DB and Display Pref
function getInfoFromBearerToken($token){
    if(!$token){
        http_response_code(404);
        return array('Error'=>'No Token included');
    }
    $token = explode(' ', $token)[1];
    $DBAdmin = new DB_Admin;
    $loginData = $DBAdmin->query('SELECT DBName, ListDisplayPref, CompaniesID FROM
        `LoginAuth` inner join Companies on LoginAuth.CompaniesID = Companies.ID
         WHERE Token = :token', array('token'=>$token));
    if(isset($loginData[0]['DBName'])){
        return $loginData[0];
    }else{
        http_response_code(404);
        return array('Error'=>'That token is not connected to company');
    }
}
//token auth
function checkAuth(){
    Global $ApacheHeaders;
    
    if(!isset($ApacheHeaders['Authorization'])){
        http_response_code(401);
        echo stouts('Please include Token auth header', 'error');
        exit();
    }
    
    $userData = getInfoFromBearerToken($ApacheHeaders['Authorization']);
    if(isset($userData['Error'])){
        echo stouts($userData['Error'], 'error');
        exit();
    }
    return $userData;
}
//Main router for all incoming requests
function InitRouter(){
    //Globals
    global $FormBuilderArray;
    //allowed request types
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
    //Remove first item of array to account for initial /
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
    }elseif($Routes[0] == 'users'){
        //handle logout
        include('Extras/users.php');
    }elseif($Routes[0] == 'group'){
        include('Extras/group.php');
        exit();
    }elseif($Routes[0] == 'action'){
        include('Extras/action.php');
        exit();
    }elseif($Routes[0] == 'settings'){
        include('Extras/settings.php');
        exit();
    }elseif(isset($FormBuilderArray['Routes'][$Routes[0]])){
        //checks if the route is in the route array
        $localArray = $FormBuilderArray['Routes'][$Routes[0]];
        //load all the form data
        if($method == 'POST' or $method == 'PUT'){
            $PHPinput = file_get_contents('php://input');
            $PostInput = json_decode($PHPinput, 1);
            parse_str($PHPinput, $_PUT);
          
            //This is the check to see if the api should use $_POST or php://input
            if(isset($_POST[$localArray['formName']])){
                $PostData = $_POST;
            }elseif(isset($_PUT[$localArray['formName']])){
                $PostData = $_PUT;
            }elseif(isset($PostInput[$localArray['formName']])){
                $PostData = $PostInput;
            }else{
                http_response_code(400);
                echo stouts('No data Received', 'error');
                exit();
            }
        }
           
        //checks to see if the route is a view file
        if(isset($FormBuilderArray['Routes'][$Routes[0]]['view'])){
            $viewFile = "./Views/".$Routes[0].'.php';
            if(is_file($viewFile)){
                include($viewFile);
                exit();
            }
        }
        if($method == 'GET'){
            if(isset($Routes[1]) and strtolower($Routes[1]) == 'info' and isset($Routes[2]) ){
                //Return the data and structure for updating item
                selectUpdateFormItem($localArray, $Routes[0], $Routes[2]);
            }elseif(isset($Routes[1]) and  strtolower($Routes[1]) == 'info'){
                //get the form structure for 
                getFormStruct($localArray, $Routes[0]);
            }elseif(isset($Routes[1]) and $Routes[1] == 'search'){
                //Handle the individual requests
                search($localArray, $Routes[2]);
            }elseif(isset($Routes[1]) and !in_array(strtolower($Routes[1]), $requestTypes)){
                //Handle the individual requests
                selectFormItem($localArray, $Routes[1]);
            }elseif(!isset($Routes[1]) or empty($Routes[1])){
                selectFormData($localArray);
            }else{
                http_response_code(400);
                echo stouts('The action you have entered is not allowed on a GET Request', 'error');
            }
        }elseif($method == "POST"){
           
            //This is where the received form is entered into the database
            if(!empty($PostData)){
                insertFormData($PostData, $localArray, $Routes);
            }else{
                http_response_code(400);
                echo stouts('No data received', 'error');
            }
        }elseif($method == 'PUT'){
            if(!empty($PostData) and !empty($Routes[1])){
                updateFormData($PostData, $localArray, $Routes[1]);
            }else{
                http_response_code(400);
                echo stouts('No data received', 'error');
            }
        }elseif($method == 'DELETE'){
            if(!empty($Routes[1])){
                deleteItem($localArray, $Routes[1]);
            }else{
                http_response_code(400);
                echo stouts('Please include an ID', 'error');
            }
        }
    }else{
        http_response_code(404);
        echo stouts('That Route Does Not Exist', 'error');
    }
}
//search form data
function search($localArray, $searchVal){
    $sendData = [];

    //this is where the auth header is checked
    $AuthData = checkAuth();

    $tokenData = json_decode($AuthData['ListDisplayPref'], true);

    $selectItems = [];
    foreach($localArray['items'] as $item){
        if(in_array($item['name'], $localArray['search'])){
            $sendData['Info'][$item['name']] = $item['inputLabel'];
            $selectItems[] = $item['name'];
        }
        
        
    }
    $selectItems[] = 'ID';
    $selectItems = implode(', ', $selectItems);

    if(!isset($localArray['search'])){
        http_response_code(404);
        echo stouts('You cant search this data', 'error');
        exit();
    }
    $searchData=[];
    foreach($localArray['search'] as $searchItem){
        $searchData[] = ' '.$searchItem.' LIKE "%'.$searchVal.'%"';
    }
    $limit = '';
    if(isset($_GET['limit'])){
        $limit = ' LIMIT '. intval($_GET['limit']);
    }
  
    $searchQuery = '('. implode(' or ', $searchData).')';
    $DB = new DB($AuthData['DBName']);

    $groupCheck = '';
    if(isset($_GET['group'])){
        $groupCheck = ' and GroupId IS NULL';
    }

    $data = $DB->query('SELECT '.$selectItems.' from '.$localArray['tableName'].' WHERE '.$searchQuery.' '.$groupCheck.' '.$limit.' ');

    $sendData["Data"] = $data;

    echo json_encode($sendData);
}
//handler updating the db
function updateFormData($formData, $localArray, $ID){
    Global $ApacheHeaders;

    //this is where the auth header is checked
    $AuthData = checkAuth();
    
    $DB = new DB($AuthData['DBName']);
    $outArray = [];
    $dataArray = [];
    foreach($localArray['items'] as $items){
        if(isset($formData[$items['name']]) and $formData[$items['name']] != ""){
            $outArray[] = $items['name'];
            $dataArray[$items['name']] =  $formData[$items['name']];
        }
    }

    if(isset($localArray['runStatsFunc'])){
        $StatID = $DB->query("SELECT ".$localArray['masterLink']." from ".$localArray['tableName']." WHERE ID=:ID", array('ID'=>$ID))[0][$localArray['masterLink']];
    }

    $final = [];
    foreach($outArray as $out){
        $final[] = $out.'=:'.$out;
    }
    $final = implode(', ', $final);
    $dataArray['ID'] = $ID;
    $dataUpdate = $DB->query('UPDATE '.$localArray['tableName'].' SET '.$final.' WHERE ID=:ID', $dataArray);
    http_response_code(201);
    echo stouts('Cow Updated successfully', 'success');

    if(isset($localArray['runStatsFunc'])){
        $localArray['runStatsFunc']($localArray['masterTable'], $StatID, $DB);
    }
    


}
//form builder for the update system
function selectUpdateFormItem($formArray, $redirectName, $ID){
    $sendData = [];
    
    //this is where the auth header is checked
    $AuthData = checkAuth();
    
    $onlyDisplay = null;
    if(isset($localArray['ListDisplayPref']) and $localArray['ListDisplayPref']){
        $onlyDisplay = json_decode($AuthData['ListDisplayPref'], true);
    }
    $selectItems = [];
    if($onlyDisplay != null){
        
        foreach($formArray['items'] as $item){
            if($item['typeName'] == 'Stat') continue;
            if(isset($item['secondTable'])) continue;
            if(isset($onlyDisplay[$item['name']])){
                $sendData['Info'][$item['name']] = $item['inputLabel'];
                $selectItems[] = $item['name'];
            }
        }
    }else{
        foreach($formArray['items'] as $item){
            if($item['typeName'] == 'Stat') continue;
            if(isset($item['secondTable'])) continue;
            $sendData['Info'][$item['name']] = $item['inputLabel'];
            $selectItems[] = $item['name'];
        }
    }
    $selectItems[] = 'ID';
    $selectItems = implode(', ', $selectItems);
    $DB = new DB($AuthData['DBName']);

    $data = $DB->query("SELECT $selectItems from ".$formArray['tableName']." WHERE ID=:ID order By Adate Desc", array('ID'=>$ID));
    if(!isset($data[0]['ID'])){
        http_response_code(404);
        echo stouts('The ID is invalid', 'error');
        exit();
    }

    $updateData = $data[0];

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
    $arrayToSend['form']['callBack'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$redirectName.'/'.$ID;
    foreach($formArray['items'] as $items){

        if(isset($items['noEdit'])){
            continue;
        }
        if(isset($items['secondTable'])){
            continue;
        }
        if($items['typeName'] == 'Stat'){
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
    http_response_code(201);
    echo json_encode($arrayToSend); 
}
//get structure for building the add forms
function getFormStruct($formArray, $redirectName){
    $tokenData = false;
    if(isset($formArray['tokenAuth'])){
        $DB = new DB_Admin;
        if(!isset($_GET['token'])){
            http_response_code(404);
            echo stouts('Please include create token parm', 'error');
            exit();
        }
        $authCheck = $DB->query("SELECT Token from CompCreateAuth WHERE token=:token", array('token' => $_GET['token']));
        if(!isset($authCheck[0]['Token'])){
            http_response_code(401);
            echo stouts('Invalid Token', 'error');
            exit();
        }

    }else{

        //this is where the auth header is checked
        $AuthData = checkAuth();
        
      
        $DB = new DB($AuthData['DBName']);
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
    $arrayToSend['form']['formTitle'] = (isset($formArray['formDesc']) ? "Add ". $formArray['formDesc'] : $formArray['formTitle']);
    $arrayToSend['form']['callBack'] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$redirectName;
    $displayItems = json_decode($AuthData['ListDisplayPref'], 1);
    foreach($formArray['items'] as $items){
        if(isset($displayItems[$items['name']]) and !$displayItems[$items['name']] and (!isset($items['required']) or $items['required'] != true)){
            continue;
        }
        if($items['typeName'] == 'DataOnly' or $items['typeName'] == 'Stat'){
            continue;
        }
        $itemArray = [];
        if(isset($items['type']) and $items['type'] == 'date'){
            $itemArray['defaultValue'] = date('Y-m-d');
        }
        if(isset($items['passwordConfirm'])){
            $arrayToSend['form']['passwordCheck'] = [$items['passwordConfirm'], $items['name']];
        }

        if($items['typeName'] == 'FormSelect' and isset($items['OptionsLoad'])){
            $sendOption = [];
            $optionData = $DB->query('SELECT '.$items['OptionsLoad'][1].', ID FROM '.$items['OptionsLoad'][0].'');
            if(isset($items['allowNull'])){
                $sendOption[] = [
                    'value'=>'',
                    'option'=>'None'
                ];
            }
            foreach($optionData as $option){
                $sendOption[] = [
                    'value'=>$option['ID'],
                    'option'=>$option[$items['OptionsLoad'][1]]
                ];
            }
            $itemArray['options'] = $sendOption;
        }
        foreach($items as $itemName => $item){
            
            if(in_array($itemName, $FormPassthroughItems)){
                $itemArray[$itemName] = $item;
            }
        }
        $arrayToSend['form']['fields'][] = $itemArray;
    }
    http_response_code(200);
    echo json_encode($arrayToSend);
}
//get individual info
function selectFormItem($localArray, $ID){
    global $FormBuilderArray;
    $sendData = [];

    //this is where the auth header is checked
    $AuthData = checkAuth();

    $onlyDisplay = json_decode($AuthData['ListDisplayPref'], true);
    $selectItems = [];
    if($onlyDisplay != null){
        
        foreach($localArray['items'] as $item){
            if(isset($onlyDisplay[$item['name']])){
                if($item['typeName'] == 'Stat') continue;
                $sendData['Info'][$item['name']] = $item['inputLabel'];
                $selectItems[] = $item['name'];
            }
        }
    }else{
        foreach($localArray['items'] as $item){
            if($item['typeName'] == 'Stat') continue;
            $sendData['Info'][$item['name']] = $item['inputLabel'];
            $selectItems[] = $item['name'];
        }
    }
    $selectItems[] = 'ID';
    $selectItems = implode(', ', $selectItems);
    
    $DB = new DB($AuthData['DBName']);

    //check for sub forms
    $subArray = [];
    if(isset($localArray['subArrays']) and isset($localArray['subLink'])){
       

        foreach($localArray['subArrays'] as $sub){
            if(isset($FormBuilderArray['Routes'][$sub]['orderIndex'])){
                $order = $FormBuilderArray['Routes'][$sub]['orderIndex'];
            }else{
                $order = "Adate";
            }
            $check = true;
            $da = $DB->query('SELECT * From '.$FormBuilderArray['Routes'][$sub]['tableName'].' WHERE '.$localArray['subLink'].'=:ID order by '.$order.' DESC', array('ID'=>$ID));
            foreach($da as $row){
                $each = [];
                foreach($FormBuilderArray['Routes'][$sub]['items'] as $item){
                    if(isset($row[$item['name']])){
                        $each[$item['name']] = $row[$item['name']];
                        if($check){
                            $subArray[$sub]['Info'][$item['name']] = $item['inputLabel'];
                        }
                        
                    }
                }
                $each['ID'] = $row['ID'];
                
                $subArray[$sub]["Data"][] = $each;
                $check = false;
            }
        }
        $sendData['Sub'] = $subArray;
    }
   


    $data = $DB->query("SELECT $selectItems from ".$localArray['tableName']." WHERE ID=:ID order By Adate Desc", array('ID'=>$ID));
    if(isset($data[0]['ID'])){
        
        foreach($localArray['items'] as $items){
            if(isset($items['OptionsLoad'])){
                $replaceQuery = [];
                $replaceData = $DB->query('SELECT '.$items['OptionsLoad'][1].', ID FROM '.$items['OptionsLoad'][0].'');
                foreach($replaceData as $rep){
                    $replaceQuery[$rep['ID']] = $rep[$items['OptionsLoad'][1]];
                }
                foreach($data as $dataKey=>$dataItem){
                    $data[$dataKey][$items['name']] = $replaceQuery[$dataItem[$items['name']]];
                }
            }
        }
        $sendData['Data'] = $data;
        http_response_code(201);
        echo json_encode($sendData);
    }else{
        http_response_code(404);
        echo stouts('The ID is invalid', 'error');
    }
    
}
//get bulk data
function selectFormData($localArray){
    $sendData = [];
   
    //this is where the auth header is checked
    $AuthData = checkAuth();

    $onlyDisplay = null;
    if(isset($localArray['ListDisplayPref']) and $localArray['ListDisplayPref']){
        $onlyDisplay = json_decode($AuthData['ListDisplayPref'], true);
    }
    

    $locCheck = false;
    if(isset($onlyDisplay[$localArray['location']]) and !$onlyDisplay[$localArray['location']]){
        $locCheck = true;
    } 

    $selectItems = [];
    foreach($localArray['items'] as $item){
        if($onlyDisplay != null){
            if(isset($onlyDisplay[$item['name']]) and $onlyDisplay[$item['name']]){
                $sendData['Info'][$item['name']] = $item['inputLabel'];
                if($item['typeName'] == 'Stat') continue;
                $selectItems[] = $item['name'];
            }
        }else{
            $sendData['Info'][$item['name']] = $item['inputLabel'];
            if($item['typeName'] == 'Stat') continue;
            $selectItems[] = $item['name'];
        }
        
    }
    if(isset($localArray['location'])){
        if(!in_array($localArray['location'], $selectItems)){
            $selectItems[] = $localArray['location'];
        }
    }

    if(isset($localArray['StatIncludes'])){
        foreach($localArray['StatIncludes'] as $stat){
            $selectItems[] = $stat;
        }
    }

    $selectItems[] = 'ID';
    $selectItems = implode(', ', $selectItems);

    $DB = new DB($AuthData['DBName']);

    $data = $DB->query("SELECT $selectItems from ".$localArray['tableName']." order By Adate Desc ");
    foreach($localArray['items'] as $items){

        if($items['typeName'] == 'Stat'){
            if($items['type'] == 'date-diff'){
                foreach($data as $dataKey=>$dataItem){
                    $date1 = new DateTime($data[$dataKey][$items['statData']]);
                    $date2 = new DateTime(date('Y-m-d'));
                    $interval = $date1->diff($date2);
                    $days = $interval->days;
                    if(isset($items['suffix'])) $days = $days.' '.$items['suffix'];
                    $data[$dataKey][$items['name']] = $days;
                }
            }elseif($items['type'] == 'diff'){
                foreach($data as $dataKey=>$dataItem){
                    $first = $data[$dataKey][$items['statData'][0]];
                    $second = $data[$dataKey][$items['statData'][1]];
                    $diff = $second - $first;
                    if($first > $second) $diff = $first - $second;
                    if(isset($items['suffix'])) $diff = $diff.' '.$items['suffix'];
                    $data[$dataKey][$items['name']] = $diff;
                }
            }elseif($items['type'] == 'format'){
                foreach($data as $dataKey=>$dataItem){
                    $format = $data[$dataKey][$items['statData']];
                    if($format == null and isset($items['empty'])) $format = $items['empty'];
                    if(isset($items['suffix'])) $format = $format.' '.$items['suffix'];
                    $data[$dataKey][$items['name']] = $format;
                }
            }elseif($items['type'] == 'avg-time-gain'){
                foreach($data as $dataKey=>$dataItem){
                    $statData = $items['statData'];
                    $getDate1 = $data[$dataKey][$statData[2]];
                    $getDate2 = $data[$dataKey][$statData[3]];
                    $first = $data[$dataKey][$statData[0]];
                    $second = $data[$dataKey][$statData[1]];
                    if($getDate1 == Null or $getDate2 == Null or $first == Null or $second == Null){
                        $data[$dataKey][$items['name']] = 0;
                    }
                    $date1 = new DateTime($getDate1);
                    $date2 = new DateTime( $getDate2);
                    $interval = $date1->diff($date2);
                    $days = $interval->days + 1;
                    $diff = $second - $first;
                    if($first > $second) $diff = $first - $second;
                    $avg = 0;
                    if($diff != 0 and $days != 0){
                        //echo $diff.'-'.$items['name'].' ';
                        $avg = round($diff / $days, 2);
                    }
                    if(isset($items['suffix'])) $avg = $avg.' '.$items['suffix'];
                    $data[$dataKey][$items['name']] = $avg;
                }
            }
        }
       
        if(isset($items['OptionsLoad'])){
            $replaceQuery = [];
            $replaceData = $DB->query('SELECT '.$items['OptionsLoad'][1].', ID FROM '.$items['OptionsLoad'][0].'');
            foreach($replaceData as $rep){
                $replaceQuery[$rep['ID']] = $rep[$items['OptionsLoad'][1]];
            }
            foreach($data as $dataKey=>$dataItem){
                if($dataItem[$items['name']] == '' or $dataItem[$items['name']] == null or strtolower($dataItem[$items['name']]) == 'none'){
                    $data[$dataKey][$items['name']] = '';
                }else{
                    $data[$dataKey][$items['name']] = $replaceQuery[$dataItem[$items['name']]];
                }
                
            }
        }
        if(isset($items['count'])){
            foreach($data as $dataKey=>$dataItem){
                $arr = json_decode($dataItem[$items['name']], 1);
                if(is_array($arr)){
                    $data[$dataKey][$items['name']] = count($arr);
                }else{
                    $data[$dataKey][$items['name']] = 0;
                }
            }

        }
    }
    $dataClean = [];
    foreach($data as $keyL1=>$l1){
        foreach($l1 as $keyL2=>$l2){
            if(isset($sendData['Info'][$keyL2])){
                $dataClean[$keyL1][$keyL2] = $l2;
            }
        }
        $dataClean[$keyL1]['ID'] = $l1['ID'];
    }
    

    //TODO: Update this so that it sorts the locations even if you don't include that
    
    if(isset($localArray['location'])){
        $tempArray = [];
        $locations = [];
        $noPen = [];
        foreach($dataClean as $row){
            $loc = $row[$localArray['location']];
            if($locCheck){
                unset($row[$localArray['location']]);
            }
            if($loc != ''){
                $tempArray[$loc][] = $row;
                if(!in_array($loc, $locations)){
                    $locations[] = $loc;
                }
            }else{
                $noPen[] = $row;
            }
        }
        sort($locations);
        foreach($locations as $local){
            $sendData['Data']['Locations'][$local] = $tempArray[$local];
        }
        $sendData['Data']['Locations']['None'] = $noPen;

    }else{
        $sendData['Data'] = $dataClean;
    }

    
    echo json_encode($sendData);
    
    
}
//insert form data
function insertFormData($ReceivedFormData, $localArray, $Routes){
    Global $FormBuilderArray;
    $DBAdmin = new DB_Admin;
    
    if(isset($localArray['tokenAuth']) and isset($localArray['dbCreate'])){
        if(!isset($ReceivedFormData['Token'])){
            http_response_code(401);
            echo stouts('Please include auth token', 'error');
            exit();
        }
        $data = $DBAdmin->query('SELECT Token, Expire from CompCreateAuth WHERE Token = :token', array('token'=>$ReceivedFormData['Token']));
        
        if(empty($data)){
            http_response_code(401);
            echo stouts('Auth Token has expired or is invalid', 'error');
            exit();
        }
    }elseif(isset($localArray['loginAuth'])){
        //this is where the auth header is checked
        $AuthData = checkAuth();
    }
    
   
    if(isset($localArray['dbCreate'])){
        $DB = $DBAdmin;
    }else{
        $DB = new DB($AuthData['DBName']);
    }
    
    $insertStringArray = [];
    $pdoDataArray = [];
    if(isset($localArray['secondTable'])){
        $secInsertStringArray = [];
        $secPdoDataArray = [];
    }
    foreach($ReceivedFormData as $itemKey => $item){
        foreach($localArray['items'] as $formItem){
            if($itemKey == $formItem['name']){
                if(isset($formItem['passwordConfirm'])){
                    continue;
                }
                if(isset($formItem['type']) and $formItem['type'] == 'password'){
                    $item = password_hash($item, PASSWORD_BCRYPT);
                }
                if(isset($formItem['unique']) and $formItem['unique'] == true){
                    $table = (isset($localArray['secondTable']) ? $localArray['secondTable'] : $localArray['tableName'] );
                    $check = $DB->query("SELECT $itemKey From $table WHERE $itemKey=:$itemKey", array($itemKey=>$item));
                    if(!empty($check)){
                        if(isset($formItem['inputLabel'])){
                            $label = $formItem['inputLabel'];
                        }elseif(isset($formItem['selectLabel'])){
                            $label = $formItem['selectLabel'];
                        }elseif(isset($formItem['textareaLabel'])){
                            $label = $formItem['textareaLabel'];
                        }else{
                            $label = $itemKey;
                        }
                        http_response_code(409);
                        echo stouts("This $label Already Exists", 'error');
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

    //here is where we will handle the sub array link
    if(isset($localArray['masterLink']) and isset($localArray['masterTable'])){
        if(isset($Routes[1])){
            $subData = $DB->query("SELECT ID From ".$localArray['masterTable']." WHERE ID=:ID", array('ID'=>$Routes[1]));
            if(isset($subData[0]['ID'])){
                $pdoDataArray[$localArray['masterLink']] = $Routes[1]; 
                $insertStringArray[] = $localArray['masterLink'];
            }else{
                http_response_code(400);
                echo stouts('Please Include A valid UUID', 'error');
            }
        }else{
            http_response_code(400);
            echo stouts('Please Include a UUID in the url', 'error');
        }
    }
   
    
    //creation of the UUID for the table item
    if(!isset($localArray['UUID']) or $localArray['UUID'] == true){
        do{
            $UUID = bin2hex(random_bytes(24));
        }while(!empty($DB->query("SELECT ID from ".$localArray['tableName']." WHERE ID = '$UUID'")));
        $insertStringArray[] = 'ID';
        $pdoDataArray['ID'] = $UUID;
    }
   
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
        if(isset($localArray['subLink'])){
            $secPdoDataArray[$localArray['subLink']] = $UUID;
            $secInsertStringArray[] = $localArray['subLink'];
        }else{
            $secPdoDataArray[$localArray['tableName'].'ID'] = $UUID;
            $secInsertStringArray[] = $localArray['tableName'].'ID';
        }
        
       
        $secValues = implode(', ',$secInsertStringArray);
        $secDataValues =':'.implode(', :',$secInsertStringArray);
        $DB->query("INSERT INTO ".$localArray['secondTable']." ($secValues) VALUES ($secDataValues)", $secPdoDataArray);
        
       
    }
    
    
    $values = implode(', ',$insertStringArray);
    $dataValues =':'.implode(', :',$insertStringArray);
    $DB->query("INSERT INTO ".$localArray['tableName']." ($values) VALUES ($dataValues)", $pdoDataArray);
    
    if(isset($localArray['secondTable'])){
        $secondArray = $FormBuilderArray['Routes'][strtolower($localArray['secondTable'])];
        if(isset($secondArray['runStatsFunc'])){
            $secondArray['runStatsFunc']($secondArray['masterTable'], $UUID, $DB);
        } 
    }

    //this is where we will run the function that adds the stats to the master table

    if(isset($localArray['runStatsFunc'])){
        $localArray['runStatsFunc']($localArray['masterTable'], $Routes[1], $DB);
    }

    if(isset($localArray['tokenAuth'])){
        $data = $DB->query('DELETE from '.$localArray['tokenAuth'].' WHERE Token = :token', array('token'=>$ReceivedFormData['Token']));
    }
    http_response_code(201);
    echo stouts($localArray['success'], 'success');
    
}
//delete item
function deleteItem($formArray, $ID){
    
    //this is where the auth header is checked
    $AuthData = checkAuth();
    
    $DB = new DB($AuthData['DBName']);
    
    if(isset($formArray['allowCompleteDelete']) and $formArray['allowCompleteDelete'] == false){
        $checkNumber = count($DB->query("SELECT ID from ".$formArray['tableName'].""));
        if($checkNumber == 1){
            http_response_code(409);
            echo stouts('This is the last '.$formArray['formDesc'].' You cannot delete it', 'error');
            exit();
        }
    }

    $data = $DB->query("SELECT ID from ".$formArray['tableName']." WHERE ID=:ID", array('ID'=>$ID));
    if(!isset($data[0]['ID'])){
        http_response_code(404);
        echo stouts('The ID is invalid', 'error');
        exit();
    }
    if(isset($formArray['runStatsFunc'])){
        $StatID = $DB->query("SELECT ".$formArray['masterLink']." from ".$formArray['tableName']." WHERE ID=:ID", array('ID'=>$ID))[0][$formArray['masterLink']];
    }


    if(isset($formArray['cleanUp']) and isset($formArray['cleanUp']['type']) and isset($formArray['cleanUp']['target']) and isset($formArray['cleanUp']['query'])){
        if($formArray['cleanUp']['type'] == 'move'){
            if(!isset($_GET['move'])){
                http_response_code(404);
                echo stouts('Please Include a move ID to move items to', 'error');
                exit();
            }
            foreach($formArray['cleanUp']['target'] as $target){
                $check = $DB->query('SELECT ID from '.$formArray['tableName'].' WHERE ID=:id',array('id'=>$_GET['move']));
                if(!isset($check[0]['ID'])){
                    http_response_code(404);
                    echo stouts('Move ID does not exist', 'error');
                    exit();
                }
                if($_GET['move'] == $ID){
                    http_response_code(404);
                    echo stouts('Both ID\'s are the same no action taken', 'error');
                    exit();
                }
                $data = $DB->query('UPDATE '.$target.' SET Pen=:pen WHERE '.$formArray['cleanUp']['query'].'=:id',array('pen'=>$_GET['move'], 'id'=>$ID));
            }
        }elseif($formArray['cleanUp']['type'] == 'delete'){
            foreach($formArray['cleanUp']['target'] as $target){
                $DB->query("DELETE FROM $target WHERE ".$formArray['cleanUp']['query']."=:id", array('id'=>$ID));
            }
        }
    }

    $del = $DB->query('DELETE FROM '.$formArray['tableName'].' WHERE ID=:ID', array('ID'=>$ID));
    echo stouts('Item Successfully deleted', 'success');
    if(isset($formArray['runStatsFunc'])){
        $formArray['runStatsFunc']($formArray['masterTable'], $StatID, $DB);
    }
}

//init the router
InitRouter();