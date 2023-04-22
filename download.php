<?php

include 'includes/phpqrcode/qrlib.php';
require 'functions.php';
/** @var type $_GET */
$id = filter_input(INPUT_GET, 'id');
$row = db_query("select * from users where id = :id limit 1", ['id' => $id]);

if ($row) {
    $row = $row[0];
} else {
    redirect("login.html");
}
/**
 * VCard generator test - can save to file or output as a download
 */
require_once __DIR__ . '/JeroenDesloovere/VCard.php';

use JeroenDesloovere\VCard\VCard;

// define vcard
$vcard = new VCard();

// define variables
$firstname = ucfirst($row['firstname']);
$lastname = '';
$additional = '';
$prefix = '';
$suffix = '';

// add personal data
$vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

// add work data
$vcard->addCompany(ucfirst($row['company']));
$vcard->addJobtitle(ucfirst($row['job_title']));
$vcard->addEmail($row['email']);
$vcard->addPhoneNumber($row['phone'], 'PREF;WORK');
$vcard->addPhoneNumber($row['mobile'], 'MOBILE');
$vcard->addAddress($row['address']);
$vcard->addURL($row['website'],'website');
$vcard->addURL($row['instagram'],'instagram');
$vcard->addURL($row['linkedin'],'linkedin');
$vcard->addURL($row['twitter'],'twitter');
$vcard->addURL($row['facebook'],'facebook');
$vcard->addURL($row['youtube'],'youtube');
$vcard->addPhoneNumber($row['whatsapp'],'whatsapp');
$vcard->addURL($row['tiktok'],'tiktok');

$vcard->addPhoto(__DIR__ . '/'.get_image($row['image']));
return $vcard->download();
