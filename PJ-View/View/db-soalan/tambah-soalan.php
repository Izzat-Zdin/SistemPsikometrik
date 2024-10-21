<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.4.0/remixicon.css" crossorigin="">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="assets/css/styles.css">
       <link rel="stylesheet" href="assets/css/tambah-kelas.css">       
       <link rel="stylesheet" href="assets/css/header.css">
       <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
       <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link rel="stylesheet" href="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.min.css" />
<title>Responsive sidebar menu - Bedimcode</title>
   </head>
   <body>
      <!-- Sidebar bg -->
      <img src="assets/img/dark-bg.jpg" alt="sidebar img" class="bg-image">

      <!--=============== HEADER ===============-->
      
      <?php include 'includes/header.php'; ?>
   
      <!--=============== SIDEBAR ===============-->
      
      <?php include 'includes/sidebar.php'; ?>
      
      <!--=============== MAIN ===============-->
<main class="main container" id="main">
    <div class="container-home">
        <h1 class="title-kelas">Urus Kelas</h1>
        <form action="action/tambah-kelas.php" method="post" class="box">
            <h2>Kelas</h2>
            <div class="form-group">
                <label for="name"></label>
                <input type="text" placeholder="Masukkan nama kelas" id="nama" name="kelas_nama">
            </div>
            <button class="exampleClass" type="submit"> Submit</button>
        </form>
    </div>
</main>


      <!--=============== MAIN JS ===============-->
      <script src="assets/js/main.js"></script>
    </body>
</html>