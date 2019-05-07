<?php
session_Start();

include_once("header.php");
?>


<body class="background">
<main style="min-height: 60vh;margin-right: 10vw;margin-left: 10vw;">
    <div class="container text-center" style="padding: 4em;">
        <h2 style="margin: 1ex;color: rgb(255,255,255);">Inloggen</h2>
        <form style="width: 100%;padding: 2em;" method="post" action="inlog_systeem.php">
            <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Gebruikersnaam</h5>
            <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center foutmeldingTekst"></h5>
            <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
                 style="margin: 1em 0em;"> <input
                        class="form-control inputforms" type="text"
                        placeholder="Gebruikersnaam" name="Gebruikersnaam" autofocus=""></div>
            <h5 class="text-center text-sm-center text-md-center text-lg-center text-xl-center">Wachtwoord</h5>
            <div class="d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex justify-content-center align-items-center flex-wrap flex-sm-wrap flex-md-nowrap flex-lg-nowrap justify-content-xl-center align-items-xl-center flex-xl-nowrap"
                 style="margin: 1em 0em;"><input
                        class="form-control inputforms" type="password"
                        name="Wachtwoord" placeholder="Wachtwoord" minlength="3"></div>
            <button class="btn btn-primary text-center" data-bs-hover-animate="pulse" type="submit" name="inloggen"
                    style="width: 100%;margin-top: 1em;background-color: #ffb357;margin-bottom: 1em;">Login
            </button>
        </form>
    </div>
</main>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/bs-animation.js"></script>
</body>

<?php include_once("footer.php")?>
