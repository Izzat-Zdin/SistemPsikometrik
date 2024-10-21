<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="gambar/mpp.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <style>
        :root {
            --size: 9;
            --color-one: #ea4335;
            --color-two: #4285f4;
            --color-three: #34a853;
            --color-four: #fbbc05;
        }

        body {
            display: grid;
            place-items: center;
            min-height: 100vh;
            background: hsl(0, 0%, 96%);
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        @property --nose {
            syntax: '<percentage>';
            initial-value: 0%;
            inherits: false;
        }

        @property --tail {
            syntax: '<percentage>';
            initial-value: 0%;
            inherits: false;
        }

        .loader {
            height: calc(var(--size) * 1vmin);
            width: calc(var(--size) * 1vmin);
            border-radius: 50%;
            mask: conic-gradient(from 45deg,
                    transparent 0 var(--tail),
                    #000 0 var(--nose),
                    transparent 0 var(--nose));
            border-style: solid;
            border-width: 5vmin;
            border-top-color: var(--color-one);
            border-right-color: var(--color-two);
            border-bottom-color: var(--color-three);
            border-left-color: var(--color-four);
            animation: load 2.5s both infinite ease-in-out, spin 3.25s infinite linear;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes load {
            0% {
                --tail: 0%;
                --nose: 0%;
            }

            40%,
            60% {
                --nose: 100%;
                --tail: 0%;
            }

            100% {
                --nose: 100%;
                --tail: 100%;
            }
        }

        .label {
            margin-top: 20px;
            font-size: 1.5em;
        }

        #page-content,
        .loading {
            transition: opacity 0.3s ease;
        }

        .loading {
            display: none;
            /* Initially hidden */
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            /* Larger font size */
            text-align: center;
        }

        #page-content {
            font-size: 2em;
            /* Larger font size for initial content */
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Page content shown initially -->
    <div id="page-content">
        <p>Sedia untuk proses keluar...</p>
    </div>

    <!-- Loading animation and message -->
    <div class="loading" id="loading">
        <div class="loader"></div>
        <div class="label" style="font-size:30px; font-weight:700;">Sedang proses keluar...</div>
    </div>

    <script>
        // Function to set a cookie
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        // Generate a unique ID for this tab
        let tabID = localStorage.getItem('tabID');

        if (!tabID) {
            tabID = 'tab-' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('tabID', tabID);
        }

        // Set the tab ID cookie
        setCookie('tabID', tabID, 1);

        // Function to show the loading animation and redirect to logout process
        function showLoadingAndLogout() {
            document.getElementById('page-content').style.opacity = '0'; // Hide initial content with transition
            setTimeout(function () {
                document.getElementById('page-content').style.display = 'none'; // Hide initial content
                document.getElementById('loading').style.display = 'flex'; // Show loading animation
                document.getElementById('loading').style.opacity = '1'; // Ensure loading animation is visible
            }, 300); // Wait for the transition to complete

            setTimeout(function () {
                window.location.href = 'logout_process.php';
            }, 2300); // Additional 2 seconds delay for demonstration
        }

        // Show loading animation after 0.3 seconds
        setTimeout(showLoadingAndLogout, 300);
    </script>
</body>

</html>
