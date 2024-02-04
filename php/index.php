<?php

include "./classes/Adatbazis.class.php";
include "./classes/Helyettesitesek.class.php";
include "./classes/Utvonal.class.php";

$utvonal = new Utvonal($_SERVER['REQUEST_URI']);
$utvonal->utvonalVizsgalat();

?>