<?php
session_start();
include 'guard-view.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/mpp.png">


    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/hubungi.css">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <title>Pelawat • Hubungi Kami</title>

    <style>
    body {
        margin: 0;
        font-family: 'Roboto', sans-serif;
    }

    ::-webkit-scrollbar {
        width: 20px;
    }

    ::-webkit-scrollbar-track {
        background: #1f1f1f;
        border-radius: 10px;
        padding-top: 40%;
    }

    ::-webkit-scrollbar-thumb {
        background: gray;
        border-radius: 10px;
        border: 3px solid #1f1f1f;
    }

    ::-webkit-scrollbar-thumb:active {
        background: white;
    }

    .bg-image {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }

    .main.container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .contact-section {
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        width: 100%;
    }

    .contact-info p,
    .contact-info a {
        margin: 10px 0;
    }

    .map iframe {
        width: 100%;
        border: none;
    }

    body,
    h2,
    table,
    th,
    td,
    button {
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
    }

    .social-icons {
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 100%;
    }

    .social-icons img {
        width: 40px;
        height: 40px;
        margin: 0 10px;
    }

    .contact-info {
        color: white;
        text-align: left;
    }

    .contact-info i {
        margin-right: 10px;
    }
    </style>
</head>

<body>
    <!-- Sidebar bg -->
    <img src="assets/img/dark-bg.jpg" alt="sidebar img" class="bg-image">

    <!--=============== HEADER ===============-->
    <?php include 'includes/header-view.php'; ?>

    <!--=============== SIDEBAR ===============-->
    <?php include 'includes/sidebar-view.php'; ?>

    <!--=============== MAIN ===============-->
    <main class="main container" id="main">
        <h1
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 15%; left:22%">
            HUBUNGI KAMI</h1>

        <div class="contact-section"
            style="background-color:#333333; position:absolute; top:23.5%; left:22.5%; height:79.5%;">
            <div style="display: flex; align-items: center; ">
                <img src="logo1.png" alt="School Logo" style="height: 120px; margin-right: 20px; margin-top:-2%;">
                <div>
                    <h2 style="color:white; font-size:20px; font-weight:900;">SEKOLAH KEBANGSAAN SERI MUDA</h2>
                    <p style="color:white;"> Seksyen 4, 35600, Alor Setar, Kedah</p>
                </div>
            </div>
            <div class="map" style="margin-bottom: 20px;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!4v1718781122985!6m8!1m7!1sGl7rSyfiWNHooJOjpD4fZA!2m2!1d3.218678391805856!2d101.7164016671404!3f233.61351123766954!4f-8.38976685662601!5f1.9587109090973311"
                    width="590" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
        <div class="contact-section"
            style="background-color:#333333; position:absolute; top:23.5%; left:63.5%; width:530px; height:23%;">
            <div class="social-icons">
                <h1
                    style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 9%; left:20%">
                    PLATFORM MEDIA</h1>
                <a href="https://www.instagram.com/" target="_blank"
                    style="position: absolute; top: 44%; left: 18%; text-align: center;">
                    <img src="instagram.svg" alt="Instagram Logo" style="width: 75px; height: 75px;">
                    <span style="display: block; color: white; font-size: 14px;">Instagram</span>
                </a>
                <a href="https://www.whatsapp.com/" target="_blank"
                    style="position: absolute; top: 44%; left: 42%; text-align: center;">
                    <img src="whatsapp.svg" alt="WhatsApp Logo" style="width: 65px; height: 75px;">
                    <span style="display: block; color: white; font-size: 14px;">WhatsApp</span>
                </a>
                <a href="https://www.facebook.com/" target="_blank"
                    style="position: absolute; top: 37%; left: 62%; text-align: center;">
                    <img src="facebook.png" alt="Facebook Logo" style="width: 100px; height: 100px;">
                    <span
                        style="display: block; color: white; font-size: 14px; position: absolute; top: 91%; left:20%;">Facebook</span>
                </a>
            </div>
        </div>
        <div class="contact-section"
            style="background-color:#333333; position:absolute; top:52.5%; left:63.5%; width:530px; height:25%;">
            <h2 style="color:white; font-size:25px; font-weight:900; text-align: left; margin-left: 0%;">SK SERI MUDA
            </h2>
            <div class="contact-info" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="flex: 1; margin-left: 3%; font-size:15.5px;">
                    <p><i class="ri-home-4-line"></i> Sekolah Kebangsaan Seri Muda, Seksyen 4, 35600, Alor Setar, Kedah
                    </p>
                    <p><i class="ri-phone-line"></i> 05-885-4312</p>
                    <p><i class="ri-user-line"></i> Muhammad Amin bin Ali</p>
                </div>
                <div style="text-align: right;">
                    <img src="code.png" alt="QR Code"
                        style="width: 130px; height: 130px; position:sticky; margin-top:-34%; margin-left:-4%">
                </div>
            </div>


            <div>

    </main>

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/main.js"></script>
</body>

</html>