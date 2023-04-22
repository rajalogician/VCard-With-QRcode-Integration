<?php
include 'includes/phpqrcode/qrlib.php';
require 'functions.php';
/** @var type $_GET */
$id = filter_input(INPUT_GET, 'id');
$row = db_query("select * from users where id = :id limit 1", ['id' => $id]);

if ($row) {
    $row = $row[0];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile</title>
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <link rel="stylesheet" type="text/css" href="./css/custom-style.css">
    </head>
    <body class="profile-page" style="background-color: rgb(255, 255, 255)">
        <div class="wrapper" style="padding:0px">
            <?php
            if (!empty($row)):
                ?>
                <div class="shadow-lg bg-white edit-form barcode-section">
                    <div class="col-md-12 p-0 rounded">
                        <div class="cover-photo" style="max-height: 200px; ">
                            <div class="d-flex justify-content-between w-100 position-relative">
                                <div class="rounded-circle" style="width: 100%;">
                                    <img src="<?= get_image($row['cover']) ?>" class="js-cover img-fluid rounded" style="width: 100%;height:180px;object-fit: cover; border-bottom: 10px black solid ">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between w-100" style="margin-top: -60px; padding-left: 15px">
                            <div class="rounded-circle" style="z-index: 1">
                                <img src="<?= get_image($row['image']) ?>" class="rounded-circle js-image img-fluid rounded profile-image" style="width: 100px;height:100px;object-fit: cover;">
                            </div>
                        </div>
                        <div>
                            <p class="fs-5 fw-bold ps-3 lh-1 pt-3 underImage" style="line-height: 12px"><?= ucfirst($row['firstname']) ?></p>
                            <p class="fs-5 ps-3 lh-1 underImage"><?= ucfirst($row['job_title']) ?></p>
                            <p class="fs-5 ps-3 lh-1 underImage"><?= ucfirst($row['company']) ?></p>
                        </div>
                    </div>
                    <div class="container">
                        <?php if (!empty($row['email'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fas fa-envelope fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label><a href="mailto:<?= $row['email'] ?>"><?= $row['email'] ?></a></label>
                                </div>
                            </div>
                        <?php } if (!empty($row['phone'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label><a href="tel:<?= $row['phone'] ?>"><?= $row['phone'] ?></a></label>
                                </div>
                            </div>
                        <?php } if (!empty($row['mobile'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fas fa-mobile fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label ><a href="tel:<?= $row['mobile'] ?>"><?= $row['mobile'] ?></a></label>
                                </div>
                            </div>
                        <?php } if (!empty($row['website'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fas fa-globe fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label><a href="<?= $row['website'] ?>" target="_blank"><?= str_replace('https://', '', str_replace('http://', '', $row['website'])) ?></a></label>
                                </div>
                            </div>
                        <?php } if (!empty($row['address'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fa fa-location-dot fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <a href="https://maps.google.com?q='<?= $row['address'] ?>'" target="_blank">
                                        <?= $row['address'] ?>
                                    </a>
                                </div>
                            </div>
                        <?php } if (!empty($row['linkedin'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fa-brands fa-linkedin fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label ><a href="<?= $row['linkedin'] ?>" target="_blank">Connect with me LinkedIn</a></label>
                                </div>
                            </div>
                        <?php } if (!empty($row['twitter'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fa-brands fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label ><a href="<?= $row['twitter'] ?>" target="_blank">Follow me on Twitter</a></label>
                                </div>
                            </div>
                        <?php } if (!empty($row['instagram'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fa-brands fa-instagram fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label ><a href="<?= $row['instagram'] ?>" target="_blank">Follow me on Instagram</a></label>
                                </div>
                            </div>
                        <?php }if (!empty($row['facebook'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fa-brands fa-facebook fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label ><a href="<?= $row['facebook'] ?>" target="_blank">Follow me on Facebook</a></label>
                                </div>
                            </div>
                        <?php } if (!empty($row['youtube'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fa-brands fa-youtube fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label ><a href="<?= $row['youtube'] ?>" target="_blank">Subscribe my channel on YouTube</a></label>
                                </div>
                            </div>
                        <?php } if (!empty($row['whatsapp'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fa-brands fa-whatsapp fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label ><a href="https://wa.me/<?= $row['whatsapp'] ?>" target="_blank">Chat on WhatsApp</a></label>
                                </div>
                            </div>
                        <?php }if (!empty($row['tiktok'])) { ?>
                            <div class="row field-wrapper">
                                <div class="col-lg-2 col-2 value-icon">
                                    <span class="fa-stack fa-1x">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fa-brands fa-tiktok fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="col-lg-10 col-10 value-container">
                                    <label ><a href="<?= $row['tiktok'] ?>">Follow me on Tiktok</a></label>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="save-btn-container">
                        <button id="save-contact-btn" data-type="primary" data-size="large" data-variant="primary" class="save-btn" onclick="downloadVcf(<?= $id ?>)">
                            <span>Save Contact</span>
                            <div class="progress"></div>
                        </button>  
                        <div class="poweredby"></div>
                    </div>
                </div>
                <?php
            else:
                redirect("login.html");
            endif;
            ?>
        </div>

    </body>
</html>
<script>
    function downloadVcf(userId)
    {
        let a = document.createElement('a');
        a.href = 'download.php?id=' + userId;
        a.click();
    }
</script>
