<?php
$DB = new DB_Admin;

$uid = bin2hex(random_bytes(24));

$DB->query('INSERT into CompCreateAuth (Token, Expire) Values (:token, :expire)', array(
    'token'=> $uid,
    'expire'=>date('Y-m-d H:i:s', (time()+(60 * 24 * 10)))
));
echo "http://localhost:3000/companies/add?token=$uid";