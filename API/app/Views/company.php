<?php

if(isset($Routes[1])){
    if($Routes[1] == 'add'){
        $LocalArray = $FormBuilderArray['Forms']['company']['add'];
        $SendArray = [];
        $FormCopyArray = [
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
            'checkboxTitle'
        ];
        foreach($LocalArray['items'] as $RebuildItem){  
            $TempLocalArray = [];  
            foreach($FormCopyArray as $CopyName){
                if(isset($RebuildItem[$CopyName])){
                    $TempLocalArray[$CopyName] = $RebuildItem[$CopyName];
                }
                
            }
            $SendArray['form']['fields'][] = $TempLocalArray;
        }
        $SendArray['formName'] = $LocalArray['formName'];
        $SendArray['formTitle'] = $LocalArray['formTitle'];
        $SendArray['callBack'] =  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        if($method == 'GET'){
            echo json_encode($SendArray);
        }elseif($method == 'POST'){
            $SendFormBuilder = [];
            $PostData = json_decode(file_get_contents('php://input'), 1);
            if(isset($PostData[$LocalArray['formName']])){
                foreach($PostData as $itemKey => $item){
                    foreach($LocalArray['items'] as $formItem){
                        if($itemKey == $formItem['name']){
                            $SendFormBuilder[$formItem['name']] = $item;
                            continue;
                        }
                    }
                }
                echo json_encode(['success'=>1, "Message"=>'Company successfully Added']);
            }else{
                echo json_encode(['Error'=>1, "Message"=>'Incorrect URL']);
            }
            
        }
    }
}
