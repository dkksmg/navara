<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= base_url('assets/') ?>logo/favicon.png" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://raw.githubusercontent.com/thomaspark/bootswatch/v5/dist/simplex/bootstrap.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
    <title>Maaf, halaman tidak ditemukan.</title>
</head>

<body>
    <div class="container" style="margin-top:15%">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title" style="text-align: center">
                        Ops !!! <i style="color:red;" class="fa-thin fa-hand"></i>
                    </h3>
                </div>
                <div class="panel-body timer" onload="timer(5)">
                    <div class="time">
                        <h3 class="panel-title" style="text-align: center"> Maaf, halaman tidak ditemukan. <br>
                            Anda akan dialihkan ke halaman Utama dalam <span id="time"></span>
                        </h3>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
    var time = 15;
    setInterval(function() {
        var seconds = time % 60;
        var minutes = (time - seconds) / 60;
        if (seconds.toString().length == 1) {
            seconds = seconds;
        }
        document.getElementById("time").innerHTML = seconds + " detik.";
        time--;
        if (time == 0) {
            window.location.href = "<?= base_url() ?>";
        }
    }, 1000);
    </script>
</body>

</html>