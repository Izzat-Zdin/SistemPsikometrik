
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log Masuk</title>
    <link rel="icon" type="image/png" sizes="16x16" href="mpp.png">
    <link rel="stylesheet" href="assets/css/login.css" />
    <link rel="stylesheet" href="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous" />
</head>

<body>
    <p>
        <img src="gambar/SPP.png" alt="Logo" class="logo" />
    </p>

    <div class="container" id="container">
        <!-- Sign Up Form -->
        <div class="form-container sign-up-container">
            <form action="action/SignUpMurid.php" method="post">
                <h1>Cipta Akaun</h1>
                <input type="text" placeholder="Nama" id="fullname" name="murid_nama" required />
                <input type="email" placeholder="Email" id="email" name="murid_email" required />
                <input type="password" placeholder="Kata Laluan" id="password" name="murid_pass" required />

                <select class="option" name="kelas" required>
                    <option value="" disabled selected hidden>Pilih Kelas</option>
                    <?php
                    // Include database connection
                    include('action/connect.php');

                    // Function to fetch class options dynamically
                    function getKelasOptions($condb) {
                        $kelasOptions = "";
                        $kelasQuery = "SELECT kelas_id, kelas_nama FROM kelas";
                        $result = mysqli_query($condb, $kelasQuery);

                        // Fetching and displaying classes
                        while ($row = mysqli_fetch_assoc($result)) {
                            $kelasOptions .= "<option value='" . $row['kelas_id'] . "'>" . $row['kelas_nama'] . "</option>";
                        }
                        return $kelasOptions;
                    }

                    // Display class options
                    echo getKelasOptions($condb);
                    ?>
                </select>

                <button type="submit">Daftar Masuk</button>
            </form>
        </div>

        <!-- Sign In Form -->
        <div class="form-container sign-in-container">
            <form action="action/LoginMurid.php" method="post">
                <h1>Log Masuk</h1>

                <input type="email" placeholder="Email" id="email" name="email" required />
                <input type="password" placeholder="Kata Laluan" id="password" name="password" required />

                <button type="submit">Log Masuk</button>
            </form>
        </div>

        <!-- Overlay Panels -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Hi, Murid!</h1>
                    <p>Masukkan data anda untuk berhubung dengan kami</p>
                    <button class="ghost" id="signIn">Log Masuk</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="gambar/murid.png" width="200px" alt="Murid Image" />
                    <h1>Hello, Murid!</h1>
                    <p>Untuk berhubung, silakan log masuk dengan data peribadi anda</p>
                    <button class="ghost" id="signUp">Daftar Masuk</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to toggle between sign-in and sign-up forms
        const signUpButton = document.getElementById("signUp");
        const signInButton = document.getElementById("signIn");
        const container = document.getElementById("container");

        signUpButton.addEventListener("click", () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener("click", () => {
            container.classList.remove("right-panel-active");
        });

        // Optional: Redirect function for Guru login (if needed)
        function redirectToDashboard() {
            window.location.href = "../../PJ-Guru/login-guru.html";
        }
    </script>
</body>

</html>
