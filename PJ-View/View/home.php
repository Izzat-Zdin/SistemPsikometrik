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
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="kalendar/kalendar.css">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;1,700&display=swap"
        rel="stylesheet">
    <title>Pelawat • Laman Utama</title>

    <style>
    .slideshow-container {
        max-width: 950px;
        position: relative;
        left: -10%;
        top: 10%;
        /* Move down by 10% */
        margin: auto;
        border: 2px solid grey;
        /* Adds a grey border */
        box-sizing: border-box;
        /* Ensures padding and border are included in the element's total width and height */
    }



    .mySlides {
        display: none;
    }

    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }

    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .text {
        color: #f2f2f2;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 8px;
        width: 100%;
        text-align: center;
    }

    .dot {
        cursor: pointer;
        height: 10px;
        position: relative;
        top: -27px;
        left: -17%;
        width: 10px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
    }

    .active,
    .dot:hover {
        background-color: #717171;
    }

    .fade {
        -webkit-animation-name: fade;
        -webkit-animation-duration: 1.5s;
        animation-name: fade;
        animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
        from {
            opacity: .4
        }

        to {
            opacity: 1
        }
    }

    @keyframes fade {
        from {
            opacity: .4
        }

        to {
            opacity: 1
        }
    }

    body {
        margin: 0;
        font-family: 'Roboto', sans-serif;
    }

    .bg-image {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -1;
    }



    .contact-section {
        background: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 8px;
        max-width: 600px;
        width: 100%;
        border: 2px solid grey;
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
            style="font-size: 33px; font-family: 'Montserrat', sans-serif; font-weight: bolder; color: white; position: absolute; top: 14%; left:21%">
            PAPARAN UTAMA</h1>
        <br><br><br>
        <div class="slideshow-container" style="transform: scale(0.85) translateX(-11.5%);">
            <div class="mySlides fade">
                <img src="assets/img/slide1.png" style="width:100%">
                <div class="text">Selamat Datang</div>
            </div>

            <div class="mySlides fade">
                <img src="assets/img/slide2.png" style="width:100%">
                <div class="text">Unit Kaunseling</div>
            </div>

            <div class="mySlides fade">
                <img src="assets/img/slide3.png" style="width:100%">
                <div class="text">Apa itu Psikometrik ?</div>
            </div>

            <div class="mySlides fade">
                <img src="assets/img/slide4.png" style="width:100%">
                <div class="text">Kegunaan Psikometrik</div>
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>

        </div>
        <!---<div class="calendar" style="position:absolute; top:20%;"></div>-->

        <div class="contact-section"
            style="background-color:#333333; position:absolute; top:12.8%; left:66%; height:77.5.5%; transform: scale(0.7);">
            <div style="display: flex; align-items: center; ">
                <img src="logo1.png" alt="School Logo" style="height: 120px; margin-right: 20px; margin-top:-2%;">
                <div>
                    <h2 style="color:white; font-size:21px; font-weight:900;">SEKOLAH KEBANGSAAN SERI MUDA</h2>
                    <p style="color:white; font-size:18px;"> Seksyen 4, 35600, Alor Setar, Kedah</p>
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


    </main>

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/main.js"></script>
    <script>
    let slideIndex = 0;
    showSlides();

    function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        setTimeout(showSlides, 3000); // Change image every 2 seconds
    }

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }
    </script>
    <script src="kalendar/kalendar.js"></script>

</body>

</html>