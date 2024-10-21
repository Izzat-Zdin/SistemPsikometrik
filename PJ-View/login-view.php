<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/png" sizes="16x16" href="mpp.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log Masuk</title>
    <link rel="stylesheet" href="assets/css/login.css" />
    <link rel="stylesheet" href="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous" />
</head>

<body>
    <p>
        <img src="gambar/SPP.png" alt="Logo" class="logo" />
    </p>

    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="action/LoginView.php" method="post">
                <h1>Log Masuk</h1>

                <div class="social-container"></div>

                <!-- Change the input fields to use a single murid_ic field -->
                <input type="text" placeholder="Masukkan No. Kad Pengenalan" id="murid_ic" name="murid_ic" />
                <br>
                <button type="submit">Log Masuk</button>

                <script>
                function redirectToLogin() {
                    window.location.href = page;
                }
                </script>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>

                    <button class="ghost" id="signIn">Log Masuk</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="gambar/view.png" width="220px" />
                    <br />
                    <h1>Hello, Pelawat!</h1>
                    <p>Masukkan data anda untuk berhubung dengan kami</p>
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

    function redirectToDashboard() {
        window.location.href = "../../PJ-Guru/login-guru.html";
    }
    </script>
</body>

</html>