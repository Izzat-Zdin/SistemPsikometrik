<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="mpp.png">

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log Masuk</title>
    <link rel="stylesheet" href="assets/css/login.css" />
</head>

<body>
    <p>
        <img src="gambar/SPP.png" alt="Logo" class="logo" />
    </p>

    <!--<div>
      <button onclick="redirectToDashboard()" class="guru">
        Log Masuk sebagai Murid
      </button>
    </div>-->

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="action/SignUpGuru.php" method="post">
                <h1>Cipta Akaun</h1>
                <br />
                <input type="text" placeholder="Nama" id="fullname" name="guru_nama" required />
                <input type="email" placeholder="Email" id="email" name="guru_email" required />
                <input type="password" placeholder="Kata Laluan" id="password" name="guru_pass" required />
                <select class="option" name="kelas">
                    <option value="" disabled selected hidden>Pilih Kelas</option>
                    <?php
                    // PHP code to generate kelas options
                    include('action/connect.php');
                    function getKelasOptions($condb) {
                        $kelasOptions = "";
                        $kelasQuery = "SELECT kelas_id, kelas_nama FROM kelas";
                        $result = mysqli_query($condb, $kelasQuery);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $kelasOptions .= "<option value='" . $row['kelas_id'] . "'>" . $row['kelas_nama'] . "</option>";
                        }
                        return $kelasOptions;
                    }
                    echo getKelasOptions($condb);
                    ?>
                </select>
                <br />
                <button type="submit">Daftar Masuk</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="action/Login.php" method="post" id="loginForm">
                <h1>Log Masuk</h1>
                <br />
                <input type="email" placeholder="Email" id="login_email" name="email" required />
                <input type="password" placeholder="Kata Laluan" id="login_password" name="password" required />
                <br />

                <div class="radio-options" style="display: flex; gap: 20px">
                    <label style="display: flex; align-items: center">
                        <input type="radio" name="user_type" value="guru" checked style="margin-right: 10px" />
                        <span style="font-weight: bold; font-size: 17px">Guru</span>
                    </label>
                    <label style="display: flex; align-items: center">
                        <input type="radio" name="user_type" value="penyelia" style="margin-right: 5px" />
                        <span style="font-weight: bold; font-size: 17px">Penyelia</span>
                    </label>
                </div>

                <br />

                <button type="submit">Log Masuk</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Hi, Guru!</h1>
                    <p>Masukkan data anda untuk berhubung dengan kami</p>
                    <button class="ghost" id="signIn">Log Masuk</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="gambar/guru.png" width="220px" />
                    <br />
                    <h1>Selamat Kembali!</h1>
                    <p>Untuk berhubung, silakan log masuk dengan data peribadi anda</p>
                    <button class="ghost" id="signUp">Daftar Masuk</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    const signUpButton = document.getElementById("signUp");
    const signInButton = document.getElementById("signIn");
    const container = document.getElementById("container");

    signUpButton.addEventListener("click", () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener("click", () => {
        container.classList.remove("right-panel-active");
    });

    document
        .getElementById("loginForm")
        .addEventListener("submit", function(event) {
            const userType = document.querySelector(
                'input[name="user_type"]:checked'
            ).value;
            if (userType === "penyelia") {
                this.action = "../../PJ-Penyelia/action/LoginPenyelia.php";
            } else {
                this.action = "action/LoginGuru.php";
            }
            // Optionally, you can add additional logic here before submitting the form
        });
    </script>
</body>

</html>