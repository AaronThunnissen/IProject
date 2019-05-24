<?php
include_once("includes/header.php");
include_once("includes/functies.php");

$voorwerpID = 0;
if (!isset($_GET["voorwerpID"])) {
    return;
}
$voorwerpID = test_invoer($_GET["voorwerpID"]);
if (!is_numeric($voorwerpID)) {
    return;
}
$voorwerpEigenschappen = GetVoorwerpEigenschappen($voorwerpID);
?>

    <body>
    <div class="voorwerppagina" style="background-color:#3a3a3a;">
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="carousel slide" data-ride="carousel" id="carousel-1">
                            <div class="carousel-inner" role="listbox">
                                <?php
                                foreach (GetVoorwerpFoto($voorwerpID) as $key => $value){
                                if ($key == 0) {
                                    echo "<div class=\"carousel-item active\">";

                                } else {
                                    echo "<div class=\"carousel-item\">";

                                } ?>
                                <img class="w-100 d-block"
                                     src="http://iproject2.icasites.nl/pics/<?php echo $value['FileNaam']; ?>"
                                     alt="<?php $value['']?>" style="max-height: 300px; background-size: contain"></div>
                            <?php } ?>

                        </div>
                        <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span
                                        class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a
                                    class="carousel-control-next" href="#carousel-1" role="button"
                                    data-slide="next"><span class="carousel-control-next-icon"></span><span
                                        class="sr-only">Next</span></a>
                        </div>
                        <ol class="carousel-indicators">
                            <?php foreach (GetVoorwerpFoto($voorwerpID) as $key => $value) {
                                if ($key == 0) {
                                    echo "<li data-target=\"#carousel-1\" data-slide-to=\"$key\" class=\"active\"></li>";

                                } else {
                                    echo "<li data-target=\"#carousel-1\" data-slide-to=\"$key\"></li>";

                                }
                            } ?>


                        </ol>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col">
                            <p class="titel"><?php echo strtoupper(GetProductNaam($voorwerpID)); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex flex-column" style="height: 60%;">
                            <p class="bieden" style="margin: 0%0%5%;">Tijd om te bieden:</p>
                            <p class="Timer" data-time="<?php echo $voorwerpEigenschappen[0]['Eindmoment'] ?>">
                            <div>
                                <form class="d-flex flex-row">
                                    <input class="form-control d-flex flex-row" type="text" style="margin: 0%0%20%;">
                                    <button class="btn btn-primary" type="button"
                                            style="background-color: #a9976a;height: 5%;">
                                        Bied
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 voorwerpinfo"><?php foreach ($voorwerpEigenschappen as $key => $value) { ?>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie">Verkoper: </p>
                            <p class="verkooplocatie" style="margin: 0%20%;"><?php echo $value['Gebruikersnaam']; ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Locatie: </p>
                            <p class="verkooplocatie" style="margin: 0%22%;"><?php echo $value['Plaatsnaam']; ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Startprijs: </p>
                            <p class="verkooplocatie" style="margin: 0%20%;">€<?php echo $value['Startprijs']; ?></p>
                        </div>
                        <div class="d-flex flex-row">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;">Betalingswijze: </p>
                            <p class="verkooplocatie" style="margin: 0%13%;"><?php echo $value['Betalingswijze']; ?></p>
                        </div>
                        <div class="d-flex flex-column">
                            <p class="flex-wrap verkooplocatie" style="font-size: 100%;width: 100%;">Beschrijving:</p>
                            <?php $_SESSION['Beschrijving'] = $value['Beschrijving']?>
                            <iframe class="voorwerpBeschrijving" src="voorwerp_beschrijving.php" ></iframe>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-6 bieden">
                    <p class="biedgeschiedenis"
                       style="height: 0%;margin: 0%0%0%;"><?php foreach (GetBieders($voorwerpID) as $key => $value) { ?>
                        <div class="d-flex flex-row justify-content-between">
                    <p class="d-flex flex-column justify-content-between"
                       style="width: 10%;"><?php echo $value['Gebruikersnaam']; ?></p>
                    <p class="d-flex flex-row justify-content-between"
                       style="width: 10%;"><?php echo $value['BodTijd']; ?></p>
                    <p class="d-flex flex-row justify-content-between"
                       style="width: 10%;"><?php echo $value['BodBedrag']; ?></p>
                </div>
                <?php } ?>
                <div class="d-flex flex-row justify-content-between float-right" >
                    <p class="d-flex flex-column justify-content-between biedingKolom" style="width: 10%;">Naam</p>
                    <p class="d-flex flex-row justify-content-between biedingKolom" style="width: 10%;">Tijd</p>
                    <p class="d-flex flex-row justify-content-between biedingKolom" style="width: 10%;">Bedrag</p>
                </div>
                <div class="float-right" style="margin-top: 10em">
                    <p class="anderenbekekenook">Anderen bekeken ook</p>
                    <?php foreach (GetMeestBekeken() as $key => $value) { ?>
                        <a href="voorwerppagina.php?voorwerpID=<?php echo $value['Voorwerpnummer']; ?>"><img
                                    src="http://iproject2.icasites.nl/pics/<?php echo $value['Filenaam']; ?>"
                                    width="300" heigth="300"/></a><br><br>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>
    </body>

<?php

include_once("includes/footer.php");
?>