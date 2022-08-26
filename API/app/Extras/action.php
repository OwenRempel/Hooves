<?php
Global $FormBuilderArray;
$PHPinput = file_get_contents('php://input');
$PostInput = json_decode($PHPinput, 1);
parse_str($PHPinput, $_PUT);
//This is the check to see if the api should use $_POST or php://input
if($method == 'POST' or $method == 'PUT'){
    if(isset($_POST['ActionMod'])){
        $PostData = $_POST;
    }elseif(isset($_PUT['ActionMod'])){
        $PostData = $_PUT;
    }elseif(isset($PostInput['ActionMod'])){
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

switch ($method) {
    case 'GET':
        if($Routes[1] == 'info' and !isset($Routes[2])){
            echo stouts('Nothing to show yet');
            //TODO: This needs to be updated
        }
        break;
    case 'POST':
        if($Routes[1] == 'move'){
            $penCheck = $DB->query('SELECT ID From Pens Where ID=:id', array('id'=>$PostData['Pen']));
            if(!isset($penCheck[0]['ID'])){
                http_response_code(404);
                echo stouts('That is not a valid Pen', 'error');
            }
            $pen = $PostData['Pen'];
            $entries = $PostData['Items'];

            foreach($entries as $item){
                $DB->query('UPDATE Cattle set Pen=:pen WHERE ID=:id', array('pen'=>$pen, 'id'=>$item));
            }
            http_response_code(200);
            echo stouts('Cattle Moved Successfully', 'success');
        }elseif($Routes[1] == 'delete'){
            $formArray = $FormBuilderArray['Routes']['cattle'];
            $entries = $PostData['Items'];
            foreach($entries as $item){
                $DB->query('DELETE From Cattle Where ID=:id', array('id'=>$item));
                foreach($formArray['cleanUp']['target'] as $target){
                    $DB->query('DELETE from '.$target.' WHERE '.$formArray['cleanUp']['query'].'=:id', array('id'=>$item));
                }
            }
            http_response_code(200);
            echo stouts('Cattle Deleted Successfully', 'success');
        }else{
            http_response_code(404);
            echo stouts('That is not a valid Route', 'error');
        }
        break;
    default:
        http_response_code(405);
        echo stouts('That Method is not valid', 'error');
        break;
}