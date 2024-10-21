<header class="header">
    <div class="header__container container">
        <div class="header__toggle" id="header-toggle">
            <i class="ri-menu-line"></i>

        </div>
        <img src="assets/img/logo.png" alt="" class="logo-img">
        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
        <a>

            <a href="../../../PJ-Home/tamat-session.php" class="sidebar__logout" title="Log Keluar">
                <i class="ri-logout-box-r-line"></i>
            </a>
            <style>
            .logo-img {
                width: 250px;
                height: auto;
                position: absolute;
                left: 5%;
                z-index: -1;
            }

            .clock {
                left: 48%;
                margin-top: -6px
            }


            .sidebar__logout {
                position: absolute;
                left: 96.8%;
                width: 57px;
                display: grid;
                padding: 0.6rem;
                border-radius: 0.25rem;
                transition: background .3s;
                background-color: #750e21;
            }

            .sidebar__logout-floating {
                display: none;
            }

            .sidebar__logout i {
                color: white;
                font-size: 2.15rem;
            }

            .sidebar__logout:hover {
                background-color: red;
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                color: var(--white-color);
            }
            </style>
        </a>
    </div>
</header>




<script>
src = "assets/js/clock.js"
</script>

<script>
var loadFile = function(event) {
    var image = document.getElementById("output");
    image.src = URL.createObjectURL(event.target.files[0]);
};
</script>
<script>
function showTime() {
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if (h == 0) {
        h = 12;
    }

    if (h > 12) {
        h = h - 12;
        session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerHTML = time;

    setTimeout(showTime, 1000);
}

showTime();
</script>