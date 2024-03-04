<?php

include "./classes/Adatbazis.class.php";

$sqlMuvelet = "SELECT verify FROM felhasznalok WHERE felhasznalonev = '{$_GET['felhasznalonev']}'";
$sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
if ($sqlEredmeny[0]['verify'] == $_GET['verify']) {
    $sqlMuvelet = "UPDATE felhasznalok SET verify = NULL WHERE felhasznalonev = '{$_GET['felhasznalonev']}'";
    $sqlEredmeny = Adatbazis::adatValtoztatas($sqlMuvelet);
}
header("Location: ../index.html");
exit();
return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);

?>