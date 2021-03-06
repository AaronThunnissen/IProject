<?php
session_start();
include_once "includes/functies.php";
include_once "includes/database.php";
$vraagNummer = genereerVraagNummer($dbh);
$locatieRegistratiesysteem = "Location: registratie_systeem.php";
$locatieFouteLink = "Location: registreren_emailpagina.php";
$maximumlengteGegevens = 50;
$foutmeldingen = array("AchternaamErr" => "", "VoornaamErr" => "", "EmailErr" => "", "Adres1Err" => "", "PostcodeErr" => "", "PlaatsnaamErr" => "", "LandErr" => "", "GeboorteDatumErr" => "", "TelefoonErr" => "", "GebruikersNaamErr" => "", "wachtwoord1Err" => "", "wachtwoord2Err" => "", "AntwoordErr" => "");
$_SESSION['registratieFoutmeldingen'] = $foutmeldingen;
$GebruikersnaamTelling = 0;
$wachtwoordMinimaalAantalTekens = 6;
$registratieGegevens = array("Emailadres" => "", "Voornaam" => "", "Achternaam" => "", "Adres_1" => "", "Adres_2" => "", "Postcode" => "", "Plaatsnaam" => "", "Land" => "", "Geboortedatum" => "", "Telefoonnummer" => "", "Gebruikersnaam" => "", "Wachtwoord" => "", "vraagNummer" => "", "AntwoordOpVraag" => "");
$_SESSION['registratieGegevens'] = $registratieGegevens;

// Controlleerd of de gebruiker de juiste gegevens heeft ingevuld
if (empty($_SESSION['Emailadres'])) {
    $_SESSION['foutmelding'] = "Deze link is niet geldig, laat een mailtje naar je sturen";
    header($locatieFouteLink);
    return;
}

if (isset($_POST['registreer'])) {
    $Voornaam = test_invoer($_POST['Voornaam']);
    testInputVoorFouten("Voornaam", "VoornaamErr", $Voornaam);

    $Achternaam = test_invoer($_POST['Achternaam']);
    testInputVoorFouten("Achternaam", "AchternaamErr", $Achternaam);

    if (empty($_POST['Adres_1'])) {
        $_SESSION['registratieFoutmeldingen']['Adres1Err'] = "Minimaal 1 adres moet worden opgegeven";
    } elseif (ControleerAdres($_POST['Adres_1']) == false) {
        $_SESSION['registratieFoutmeldingen']['Adres1Err'] = "De adres gegevens zijn onjuist";
    } else {
        $_SESSION['registratieGegevens']["Adres_1"] = test_invoer($_POST['Adres_1']);
        if (test_invoer($_POST['Adres_2'])) {
            $_SESSION['registratieGegevens']["Adres_2"] = test_invoer($_POST['Adres_2']);
        }
    }

    $Postcode = test_invoer($_POST['Postcode']);
    if (empty($Postcode)) {
        $_SESSION['registratieFoutmeldingen']['PostcodeErr'] = "Postcode is verplicht";
    } elseif (ControleerPostcode($Postcode) == false) {
        $_SESSION['registratieFoutmeldingen']['PostcodeErr'] = "Postcode is niet geldig";
    } else {
        $_SESSION['registratieGegevens']["Postcode"] = $Postcode;
    }

    $Plaatsnaam = test_invoer($_POST['Plaatsnaam']);
    testInputVoorFouten("Plaatsnaam", "PlaatsnaamErr", $Plaatsnaam);

    $Land = test_invoer($_POST['Land']);
    if($Land == "Selecteer land"){
        $_SESSION['registratieFoutmeldingen']['LandErr'] = "Land is verplicht";
    } else{
        $_SESSION['registratieGegevens']["Land"] = $Land;
    }

    $telefoonNummer = test_invoer($_POST['Telefoonnummer']);
    if (empty($telefoonNummer)) {
        $_SESSION['registratieFoutmeldingen']['TelefoonErr'] = "Telefoonnummer is verplicht";
    } elseif (ControleerTelefoonnummer($telefoonNummer) == false) {
        $_SESSION['registratieFoutmeldingen']['TelefoonErr'] = "Telefoonnummer is niet geldig";
    } else {
        $_SESSION['registratieGegevens']["Telefoonnummer"] = $telefoonNummer;
    }

    if (empty($_POST['GeboorteDatum'])) {
        $_SESSION['registratieFoutmeldingen']['GeboorteDatumErr'] = "Geboortedatum is verplicht";
    } else if (ControleerGeboortedatum($_POST['GeboorteDatum']) == false) {
        $_SESSION['registratieFoutmeldingen']['GeboorteDatumErr'] = "Geboortedatum is in de toekomst";
    } else {
        $_SESSION['registratieGegevens']["Geboortedatum"] = date("m-d-Y", strtotime($_POST['GeboorteDatum']));
    }

    $Gebruikersnaam = test_invoer($_POST['Gebruikersnaam']);
    $Tellinggebruikersnaam = vergelijkloginwaarde("Gebruikersnaam", $Gebruikersnaam, $dbh);
    if (empty($_POST['Gebruikersnaam'])) {
        $_SESSION['registratieFoutmeldingen']['GebruikersNaamErr'] = "Gebruikersnaam is verplicht";
    } elseif ($Tellinggebruikersnaam) {
        $_SESSION['registratieFoutmeldingen']['GebruikersNaamErr'] = "Deze gebruikersnaam is al in gebruik, kies een andere gebruikersnaam";
    } else {
        $_SESSION['registratieGegevens']["Gebruikersnaam"] = $Gebruikersnaam;
    }

    $wachtwoord = test_invoer($_POST['Wachtwoord']);
    $herhaalWachtwoord = test_invoer($_POST['Herhaalwachtwoord']);
    if (empty($wachtwoord) || strlen($wachtwoord) < $wachtwoordMinimaalAantalTekens || kijkVoorLetters($wachtwoord) == false || kijkVoorCijfers($wachtwoord) == false) {
        $_SESSION['registratieFoutmeldingen']['wachtwoord1Err'] = "Kies een wachtwoord met minimaal " . $wachtwoordMinimaalAantalTekens . " karakters, met minimaal 1 letter en 1 cijfer";
    } elseif (empty($herhaalWachtwoord) || $herhaalWachtwoord != $wachtwoord) {
        $_SESSION['registratieFoutmeldingen']['wachtwoord2Err'] = "De twee wachtwoorden komen niet overeen";
    } else {
        $_SESSION['registratieGegevens']["Wachtwoord"] = $wachtwoord;
    }

    if (empty($_POST['AntwoordOpVraag'])) {
        $_SESSION['registratieFoutmeldingen']["AntwoordErr"] = "Vul een antwoord in op de vraag";
    } else {
        $_SESSION['registratieGegevens']["AntwoordOpVraag"] = test_invoer($_POST["AntwoordOpVraag"]);
        $_SESSION['registratieGegevens']["vraagNummer"] = $vraagNummer;
    }

    $EmptyTestArray = array_filter($_SESSION['registratieFoutmeldingen']);
    if (empty($EmptyTestArray)) {
        header("$locatieRegistratiesysteem");
    }
}
include_once "includes/header.php";
?>

<!-- Formulier om gegevens in te vullen -->
<div class="d-xl-flex flex-column" style="background-color: #3a3a3a;">
    <div>
        <div class="container">
              <div class="row">
                <div class=" col-md-12">
                <h2 class="text-center" style="color: rgb(255,255,255);">Registreren</h2>
                <p class = "text-center"style="color: rgb(255,255,255);margin-bottom:50px;"> Door te registreren accepteert u onze <a href="algemene_voorwaarden.php" target="_blank"> algemene voorwaarden.</p></a>
            </div>
        </div>
    </div>
    </div>
    <form  method="post" action="registreren_pagina.php">
        <div class="text-center d-flex d-xl-flex flex-row flex-wrap justify-content-xl-center">
        <div class="col registratiepagina" style="background-color: #3a3a3a;">
            <h1 style="color: rgb(255,255,255);font-size: 15px;" class = "text-center";>Vul hier je persoonlijke gegevens in</h1>
            <?php
            echo registratieFormulierItem("Voornaam", "VoornaamErr", 50, "text", "Voornaam");
            echo registratieFormulierItem("Achternaam", "AchternaamErr", 50, "text", "Achternaam");
            echo registratieFormulierItem("Geboortedatum", "GeboorteDatumErr", 50, "date", "GeboorteDatum");
            echo registratieFormulierItem("Telefoonnummer", "TelefoonErr", 15, "tel", "Telefoonnummer"); ?>
        </div>
        <div class="col" style="background-color: #3a3a3a;">
            <h1 style="color: rgb(255,255,255);font-size: 15px;">Vul hier je adresgegevens in</h1>
            <?php
            echo registratieFormulierItem("Adresregel 1", "Adres1Err", 50, "text", "Adres_1");
            echo registratieFormulierItem("Adresregel 2", "Adres1Err", 50, "text", "Adres_2");
            echo registratieFormulierItem("Postcode", "PostcodeErr", 15, "text", "Postcode");
            echo registratieFormulierItem("Plaats", "PlaatsnaamErr", 50, "text", "Plaatsnaam");
            ?>
            <h6>Land</h6>
            <h6 class="text-left foutmeldingTekst"><?php echo $_SESSION['registratieFoutmeldingen']["LandErr"]?></h6>
            <select class="form-control inputforms" name="Land">
                <option>Selecteer land</option>
                <?php
                foreach (GeefLandenLijst($dbh) as $key => $value) {
                    if($value[Land] == $_POST["Land"]){
                        print("<option selected>$value[Land]</option>");
                    }else {
                        print("<option> $value[Land]</option>");
                    }
                }
                ?>
            </select>
        </div>
        <div class="col" style="background-color: #3a3a3a;">
            <h1 style="color: rgb(255,255,255);font-size: 15px;">Vul hier je accountgegevens in</h1>
            <?php 
            echo registratieFormulierItem("Gebruikersnaam", "GebruikersNaamErr", 50, "text", "Gebruikersnaam");
            echo registratieFormulierItem("Wachtwoord", "wachtwoord1Err", 50, "password", "Wachtwoord");
            echo registratieFormulierItem("Herhaal wachtwoord", "wachtwoord2Err", 50, "password", "Herhaalwachtwoord");
            $vraag = genereerVraag($dbh, $vraagNummer);
            echo registratieFormulierItem("$vraag", "AntwoordErr", 50, "text", "AntwoordOpVraag");
            ?>
        </div>
</div>
    <div class ="registratiebutton">
    <button class="btn btn-primary text-center Registratieknop" style="background-color: #a9976a; color: white" type="submit" name="registreer">Registreren</button>
</div>
    </form>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</div>
</body>
<?php
include_once "includes/footer.php";
?>