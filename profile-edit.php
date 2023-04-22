<?php
include 'includes/phpqrcode/qrlib.php';
require 'functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$id = $_GET['id'] ?? $_SESSION['PROFILE']['id'];

$row = db_query("select * from users where id = :id limit 1", ['id' => $id]);

if ($row) {
    $row = $row[0];
}

$path = "images/";
$qrcode = $path . $id . ".png";
$url = "http://xgraphicsolutions.com?id=$id";
// $url = "muhammadubad";
//$url = "FirstName => " . $row["firstname"] . " ------ " . "Last Name => " . $row["lastname"] . " ------ " . "Email => " . $row["email"] . " ------ " . "Image => " . $row["image"] . " ------ " . "Gender => " . $row["gender"] . " ------ " . "Date => " . $row["date"];

QRcode::png($url, $qrcode, 'H', 6, 6);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Profile</title>
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <link rel="stylesheet" type="text/css" href="./css/custom-style.css">
        <style>
            .saveDataBtn{
                top: -638px !important;
                right: 0px !important;
            }
        </style>
    </head>
    <body>
        <div class="nav-container" tabindex="0">
            <a onclick="myaction.collect_data(event, 'profile-edit')" style="background:grey; float:right; border-radius: 15px; margin-right: 15px; background: #fff" class="btn mt-1" role="button">Save Changes</a>
            <div class="nav-toggle"></div>
            <nav class="nav-items">
                <a class="text-decoration-none" href="logout.php">
                    <i class="fa fa-power-off text-black fs-3"></i> &emsp;<span class="fs-4 fw-bold text-dark ">Logout</span>
                </a>

            </nav>
        </div>
        <div class="wrapper p-0" style="margin-top: 0px !important;">
            <?php
            if (!empty($row)):
                ?>
                <div class="shadow-lg bg-white edit-form ">
                    <div class="col-md-12 position-relative p-0">
                        <div class="cover-photo" style="height: 200px; ">
                            <div class="position-absolute" style="top: 155px;right: 30px;z-index: 1;">
                                <div class="mb-3">
                                    <button style="width: 50px; height: 50px" class="bg-white rounded-circle">
                                        <label for="CoverInput">
                                            <i class="bi bi-pencil"></i>
                                        </label>
                                        <form action="upload.php">
                                            <input type="file" onchange="display_cover(this.files[0])" id="CoverInput" class="js-cover-input" style=" cursor: pointer;  display: none"/>
                                            <input type="submit" id="Up" style="display: none;" />
                                        </form>
                                    </button>
                                </div>
                                <div><small class="js-error js-error-cover text-danger"></small></div>
                            </div>
                            <div class="d-flex justify-content-between w-100 position-relative">
                                <div class="rounded-circle" style="width: 100%;">
                                    <img src="<?= get_image($row['cover']) ?>" class="js-cover img-fluid rounded" style="border-bottom: 10px black solid; width: 100%;height:180px;object-fit: cover;">
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute" style="top: 190px; left:75px;  z-index:1;">
                            <div class="mb-3">
                                <button style="width: 50px; height: 50px" class="bg-white rounded-circle">
                                    <label for="FileInput">
                                        <i class="bi bi-pencil"></i>
                                    </label>
                                    <form action="upload.php">
                                        <input type="file" onchange="display_image(this.files[0])" id="FileInput" class="js-image-input" style="cursor: pointer;  display: none"/>
                                        <input type="submit" id="Up" style="display: none;" />
                                    </form>
                                        <!--<input onchange="display_image(this.files[0])" class="js-image-input form-control" type="file" class="bg-white" id="formFile">-->
                                </button>
                            </div>
                            <div><small class="js-error js-error-image text-danger"></small></div>
                        </div>
                        <div class="d-flex justify-content-between w-100 position-relative" style="margin-top: -60px; margin-left: 10px;">
                            <div class="rounded-circle">
                                <img src="<?= get_image($row['image']) ?>" class="rounded-circle js-image img-fluid rounded" style="width: 100px;height:100px;object-fit: cover;">
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 position-relative">

                        <!-- <div class="h2">Edit Profile</div> -->

                        <form method="post" onsubmit="myaction.collect_data(event, 'profile-edit')">

                            <div class="pt-4">
                                <div class="d-flex px-2 ">
                                    <input value="<?= ucfirst($row['firstname']) ?>" type="text" class="form-control" name="firstname" placeholder="Name and surname">
                                </div>
                                <div><small class="js-error js-error-firstname text-danger ps-5 ms-2"></small></div>
                                <div class="d-flex px-2 ">
                                    <input value="<?= $row['job_title'] ?>" type="text" class="form-control" name="job_title" placeholder="Job title">
                                </div>
                                <div><small class="js-error js-error-job_title text-danger ps-5 ms-2"></small></div>
                                <div class="d-flex px-2 ">
                                    <input value="<?= $row['company'] ?>" type="text" class="form-control" name="company" placeholder="Company name">
                                </div>
                                <div><small class="js-error js-error-company text-danger ps-5 ms-2"></small></div>
                            </div>
                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-envelope fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['email'] ?>" placeholder="exampl@test.com" type="text" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div><small class="js-error js-error-email text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['phone'] ?>" type="text" placeholder="+33123456789" class="form-control" name="phone" placeholder="Phone number">
                            </div>
                            <div><small class="js-error js-error-phone text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-mobile fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['mobile'] ?>" type="text" placeholder="+33123456789" class="form-control" name="mobile" placeholder="Cell phone number">
                            </div>
                            <div><small class="js-error js-error-mobile text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fas fa-globe fa-stack-1x fa-inverse"></i>
                                </span>
                                <input type="url" name="website" class="form-control" id="url"
                                       placeholder="https://example.com"
                                       pattern="https://.*" size="30"                                       
                                       value="<?= $row['website'] ?>"
                                       required>
                            </div>
                            <div><small class="js-error js-error-website text-danger ps-5 ms-2"></small></div>


                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-location-dot fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['address'] ?>" type="text" placeholder="Address" class="form-control" name="address" placeholder="Address">
                            </div>
                            <div><small class="js-error js-error-address text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa-brands fa-linkedin fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['linkedin'] ?>" type="text" placeholder="http://www.linkedin.com/username" class="form-control" name="linkedin" placeholder="Linkedin">
                            </div>
                            <div><small class="js-error js-error-linkedin text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa-brands fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['twitter'] ?>" type="text" placeholder="http://www.twitter.com/username" class="form-control" name="twitter" placeholder="Twitter">
                            </div>
                            <div><small class="js-error js-error-twitter text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa-brands fa-instagram fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['instagram'] ?>" type="text" placeholder="http://www.instagram.com/username" class="form-control" name="instagram" placeholder="Instagram">
                            </div>
                            <div><small class="js-error js-error-instagram text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa-brands fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['facebook'] ?>" type="text" class="form-control" placeholder="http://www.facebook.com/username" name="facebook" placeholder="Facebook">
                            </div>
                            <div><small class="js-error js-error-facebook text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa-brands fa-youtube fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['youtube'] ?>" type="text" class="form-control" placeholder="http://www.youtube.com/channel" name="youtube" placeholder="Youtube">
                            </div>
                            <div><small class="js-error js-error-youtube text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa-brands fa-whatsapp fa-stack-1x fa-inverse"></i>
                                </span>
                                <!--<input value="<?= $row['whatsapp'] ?>" type="number" class="form-control" name="whatsapp" placeholder="Whatsapp">-->
                                <input value="<?= $row['whatsapp'] ?>" type="text"  onkeypress="return /[0-9]/i.test(event.key)" class="form-control whatsapp" name="whatsapp" placeholder="Whatsapp"
                                       pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                                       required>
                            </div>
                            <div><small class="js-error js-error-whatsapp text-danger ps-5 ms-2"></small></div>

                            <div class="d-flex px-2 gap-3 ">
                                <span class="fa-stack fa-1x">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fa-brands fa-tiktok fa-stack-1x fa-inverse"></i>
                                </span>
                                <input value="<?= $row['tiktok'] ?>" type="text" class="form-control" placeholder="http://www.tiktok.com/username" name="tiktok" placeholder="Tiktok">
                            </div>
                            <div><small class="js-error js-error-tiktok text-danger ps-5 ms-2"></small></div>

                        </form>

                    </div>
                </div>

                <div class="shadow-lg bg-white mt-2 p-1 barcode-section">
                    <div class="col-md-12" style="text-align: center">
                        <img src='<?php echo $qrcode ?>' class="position-relative qrcode-container"/>
                    </div>
                    <div class="col-md-12 " style="text-align: center">
                        <a href="<?php echo $qrcode ?>" download="proposed_file_name" style=" border-radius: 15px" class="btn btn-outline-dark" role="button">Download QR Code</a>
                    </div>
                </div>
                <div class="poweredby"></div>

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
    var image_added = false;

    function display_image(file)
    {
        var img = document.querySelector(".js-image");
        img.src = URL.createObjectURL(file);

        image_added = true;
    }
    var cover_added = false;

    function display_cover(file)
    {
        var cover = document.querySelector(".js-cover");
        cover.src = URL.createObjectURL(file);

        cover_added = true;
    }

    var myaction =
            {
                collect_data: function (e, data_type)
                {
                    e.preventDefault();
                    e.stopPropagation();

                    var inputs = document.querySelectorAll("form input, form select");
                    let myform = new FormData();
                    myform.append('data_type', data_type);

                    for (var i = 0; i < inputs.length; i++) {

                        myform.append(inputs[i].name, inputs[i].value);
                    }

                    if (image_added)
                    {
                        myform.append('image', document.querySelector('.js-image-input').files[0]);
                    }
                    if (cover_added)
                    {
                        myform.append('cover', document.querySelector('.js-cover-input').files[0]);
                    }

                    myaction.send_data(myform);
                },

                send_data: function (form)
                {
                    var ajax = new XMLHttpRequest();
                    ajax.addEventListener('readystatechange', function () {
                        if (ajax.readyState == 4)
                        {
                            myaction.handle_result(ajax.responseText);
                        }
                    });

                    ajax.open('post', 'ajax.php', true);
                    ajax.send(form);
                },

                handle_result: function (result)
                {
                    console.log(result);
                    var obj = JSON.parse(result);
                    if (obj.success)
                    {
                        window.location.href = 'index.php?id=<?= $id ?>';
                    } else {

                        //show errors
                        let error_inputs = document.querySelectorAll(".js-error");

                        //empty all errors
                        for (var i = 0; i < error_inputs.length; i++) {
                            error_inputs[i].innerHTML = "";
                        }

                        //display errors
                        for (key in obj.errors)
                        {
                            document.querySelector(".js-error-" + key).innerHTML = obj.errors[key];
                        }
                    }
                }
            };



    /* Navbar */


    const nav = document.querySelector(".nav-container");

    if (nav) {
        const toggle = nav.querySelector(".nav-toggle");

        if (toggle) {
            toggle.addEventListener("click", () => {
                if (nav.classList.contains("is-active")) {
                    nav.classList.remove("is-active");
                } else {
                    nav.classList.add("is-active");
                }
            });

            nav.addEventListener("blur", () => {
                nav.classList.remove("is-active");
            });
        }
    }

</script>
