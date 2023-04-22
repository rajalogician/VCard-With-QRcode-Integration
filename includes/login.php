<?php

$arr = [];
$arr['username'] = $_POST['username'];

$row = db_query("select * from users where username = :username limit 1", $arr);
if (!empty($row)) {
    $row = $row[0];

    //check the password
    if (password_verify($_POST['password'], $row['password'])) {
        //password correct
        $info['success'] = true;
        $_SESSION['PROFILE'] = $row;
    } else {
        $info['errors']['username'] = "Wrong username or password";
    }
} else {
    $info['errors']['username'] = "Wrong username or password!";
}