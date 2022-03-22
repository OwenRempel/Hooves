<?php 
include('../Extras/FormBuilderArray.php');

echo json_encode($_SERVER);


echo json_encode(apache_request_headers());
/*
global $FormBuilderArray;
 
$out_array = [];
foreach($FormBuilderArray['Routes']['cattle']['items'] as $item){
    $out_array[$item['name']] = True;
}

echo json_encode($out_array);

*/