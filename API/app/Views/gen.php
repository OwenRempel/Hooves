<?php
/*
$DB = new DB_Admin;

$uid = bin2hex(random_bytes(24));

$DB->query('INSERT into CompCreateAuth (Token, Expire) Values (:token, :expire)', array(
    'token'=> $uid,
    'expire'=>date('Y-m-d H:i:s', (time()+(60 * 24 * 10)))
));
echo "http://".$_SERVER['SERVER_NAME'].":3000/companies/add?token=$uid";



$DB = new DB('Hoves$2$OwensRanch$250d03a4be0f7c37');
$i = 0;
while($i < 1000){
    $users = ['Terrilee', 'Clintin', 'John', 'Dustin', 'Terry', 'Agnes', 'Owen'];
    $age = ['Heffer', 'Steer', 'Bull'];
    $des = ['This is a cow', 'What a great cow', 'This cow is a bad one', 'Look out for this one'];
    $pens = [14, 21, 22, 23, 24, ''];
    do{
        $secUUID = bin2hex(random_bytes(24));
    }while(!empty($DB->query("SELECT ID from Cattle WHERE ID='$secUUID'")));
    $ID = $secUUID;
    $Tag = 'A1'.$i;
    $dateKey = rand(1627557582,1647560582);
    $buyDate = date('Y-m-d', $dateKey);
    $penDate = $buyDate;
    $check = rand(0,1);
    if($check == 1){
        $pendateKey = rand($dateKey,1647560582);
        $penDate = date('Y-m-d', $pendateKey);
    }
    $price = rand(1000, 100000);
    $invest = $users[array_rand($users)];
    $owner = $users[array_rand($users)];
    $type = $age[array_rand($age)];
    $pen = $pens[array_rand($pens)];
    $desc = $des[array_rand($des)];
    echo "$Tag -- $ID\n";
    $DB->query("INSERT INTO Cattle (Tag, BuyDate, HerdsMan, Investor, Price, AgeState, PenDate, Pen, Description, ID) VALUES ('$Tag', '$buyDate', '$invest', '$owner', '$price', '$type', '$penDate', '$pen', '$desc', '$ID')");
    $i++;
}
*/