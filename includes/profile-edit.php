<?php

//validate firstname
//if (empty($_POST['firstname'])) {
//    $info['errors']['firstname'] = "A first name is required";
//} else
//if (!preg_match("/^[\p{L}]+$/", $_POST['firstname'])) {
//    $info['errors']['firstname'] = "First name cant have special characters or spaces and numbers";
//}
//
////validate lastname
//if (empty($_POST['lastname'])) {
//    $info['errors']['lastname'] = "A last name is required";
//} else
//if (!preg_match("/^[\p{L}]+$/", $_POST['lastname'])) {
//    $info['errors']['lastname'] = "Last name cant have special characters or spaces and numbers";
//}
//validate email
if (empty($_POST['email'])) {
    $info['errors']['email'] = "An email is required";
} else
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $info['errors']['email'] = "Email is not valid";
}

////validate gender
//$genders = ['Male', 'Female'];
//if (empty($_POST['gender'])) {
//    $info['errors']['gender'] = "A gender is required";
//} else
//if (!in_array($_POST['gender'], $genders)) {
//    $info['errors']['gender'] = "Gender is not valid";
//}
//
////validate password
//if (!empty($_POST['password'])) {
//
//    if ($_POST['password'] !== $_POST['retype_password']) {
//        $info['errors']['password'] = "Passwords dont match";
//    } else
//    if (strlen($_POST['password']) < 8) {
//        $info['errors']['password'] = "Password must be at least 8 characters long";
//    }
//}

if (!empty($_FILES['image']['name'])) {
    $folder = "uploads/";
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
        file_put_contents($folder . 'index.html', 'Access denied');
    }

    $allowed = ['image/jpeg', 'image/png'];
    if (in_array($_FILES['image']['type'], $allowed)) {
        $image = $folder . time() . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    } else {
        $info['errors']['image'] = "Only images of this type allowed: " . implode(", ", $allowed);
    }
}

if (!empty($_FILES['cover']['name'])) {
    $cover_folder = "uploads/covers/";
    if (!file_exists($cover_folder)) {
        mkdir($cover_folder, 0777, true);
        file_put_contents($cover_folder . 'index.html', 'Access denied');
    }

    $allowed = ['image/jpeg', 'image/png'];
    if (in_array($_FILES['cover']['type'], $allowed)) {
        $cover = $cover_folder . time() . $_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], $cover);
    } else {
        $info['errors']['cover'] = "Only covers of this type allowed: " . implode(", ", $allowed);
    }
}


if (empty($info['errors']) && $row) {
    //save to database
    $arr = [];
    $arr['email'] = $_POST['email'];
    $arr['date'] = date("Y-m-d H:i:s");
    $arr['id'] = $row['id'];

    $arr['firstname'] = $_POST['firstname'];
    $arr['job_title'] = $_POST['job_title'];
    $arr['company'] = $_POST['company'];

    $arr['phone'] = $_POST['phone'];
    $arr['mobile'] = $_POST['mobile'];

    $arr['website'] = empty($_POST['website']) ? '' : addHttp($_POST['website']);
    $arr['address'] = $_POST['address'];
    $arr['linkedin'] = empty($_POST['linkedin']) ? '' : addHttp($_POST['linkedin']);
    $arr['twitter'] = empty($_POST['twitter']) ? '' : addHttp($_POST['twitter']);
    $arr['instagram'] = empty($_POST['instagram']) ? '' : addHttp($_POST['instagram']);
    $arr['facebook'] = empty($_POST['facebook']) ? '' : addHttp($_POST['facebook']);
    $arr['youtube'] = empty($_POST['youtube']) ? '' : addHttp($_POST['youtube']);
    $arr['whatsapp'] = $_POST['whatsapp'];
    $arr['tiktok'] = empty($_POST['tiktok']) ? '' : addHttp($_POST['tiktok']);

    $image_query = "";
    if (!empty($image)) {
        $arr['image'] = $image;
        $image_query = ",image = :image";
    }

    $cover_query = "";
    if (!empty($cover)) {
        $arr['cover'] = $cover;
        $cover_query = ",cover = :cover";
    }

//    $password_query = "";
//    if (!empty($_POST['password'])) {
//        $arr['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
//        $password_query = ",password = :password";
//    }
    $query = "update users set firstname= :firstname, job_title= :job_title, company= :company, phone= :phone, mobile= :mobile, website= :website, address= :address, linkedin= :linkedin, "
            . "twitter= :twitter, instagram= :instagram, facebook= :facebook, youtube= :youtube, "
            . "whatsapp= :whatsapp, tiktok= :tiktok, date = :date, email = :email $image_query $cover_query where id = :id limit 1";
    db_query($query, $arr);

    //delete old image
    if (!empty($image) && file_exists($row['image'])) {
        unlink($row['image']);
    }

    $row = db_query("select * from users where id = :id limit 1", ['id' => $row['id']]);
    if ($row) {
        $row = $row[0];
        $_SESSION['PROFILE'] = $row;
    }

    $info['success'] = true;
}

function addHttp($url) {

    // Search the pattern
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {

        // If not exist then add http
        $url = "http://" . $url;
    }

    // Return the URL
    return $url;
}
