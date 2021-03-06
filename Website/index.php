<?php
include_once "includes/database.php";
include_once "includes/functies.php";
include_once "includes/header.php";
if (empty($_SESSION['Gebruikersnaam'])) {
    include_once "includes/banner.php";
}
?>

<!-- Content op homepagina -->
<div class="background">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="titel">Uitgelichte voorwerpen</h3>
            </div>
        </div>
        <div class="row">
            <?php echo genereerArtikelen($dbh, "SELECT TOP 4 * FROM Voorwerp WHERE VeilingGesloten = 0 AND  Voorwerpnummer IN (SELECT Voorwerpnummer FROM bod GROUP BY Voorwerpnummer HAVING count(BodBedrag)>1)", "col-md-3") ?>
        </div>
    </div>
    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="titel">High class voorwerpen</h2>
                </div>
            </div>
            <div class="row">
                <?php echo genereerArtikelen($dbh, "SELECT TOP 2 * FROM Voorwerp WHERE Startprijs >=5000 AND VeilingGesloten = 0 ORDER BY Startprijs desc", "col-md-6") ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="titel">Laatste kans!</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-between flex-wrap">
            <?php echo genereerArtikelen($dbh, "SELECT TOP 12 * FROM Voorwerp WHERE VeilingGesloten = 0 ORDER BY Eindmoment asc", "col-md-3") ?>
        </div>
    </div>
    </div>
    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="titel">Rubrieken</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-between flex-wrap">
                <?php echo genereerCatogorie($dbh, "SELECT * FROM Rubriek WHERE Rubrieknummer = 9800 OR Rubrieknummer = 12081 OR Rubrieknummer = 11232 OR Rubrieknummer = 12576", "col-md-3") ?>
            </div>
        </div>
    </div>
    <div style="margin: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="titel">Doe iets leuks met je vakantiegeld!</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-between flex-wrap">
                <?php echo genereerArtikelen($dbh, "SELECT TOP 6 * FROM Voorwerp WHERE Startprijs <5000 AND Startprijs > 1000  AND VeilingGesloten = 0 ORDER BY Startprijs desc ", "col-md-3") ?>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/timer.js"></script>
</body>
<?php
include_once "includes/footer.php";
?>