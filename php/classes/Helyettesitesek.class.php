<?php

//Az adatbázison végrehajtott műveletek:
class Helyettesitesek {
    //Összes tanár lekérdezése:
    public function osszesTanar() {
        $sqlMuvelet = "SELECT * FROM tanarok";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    //Összes osztály lekérdezése:
    public function osszesOsztaly() {
        $sqlMuvelet = "SELECT * FROM osztalyok";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    //Konkrét versenyző/k keresése:
    public function versenyzoKeres($nev) {
        $sqlMuvelet = "SELECT * FROM versenyzok WHERE nev LIKE '%{$nev}%'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }
}

?>