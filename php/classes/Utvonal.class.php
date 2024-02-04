<?php

//URL vizsgálata és érkező adatok lekérdezése/használata:
class Utvonal {
    private $teljesURL;
    private $erkezettAdatok;

    public function __construct($URL) {
        $this->teljesURL = explode('/', $URL);
        $this->erkezettAdatok = json_decode(file_get_contents("php://input"), false);
    }

    public function utvonalVizsgalat() {
        switch (end($this->teljesURL)) {
            case "osszesTanar": {
                $helyettesitesek = new Helyettesitesek();
                echo $helyettesitesek->osszesTanar();
                break;
            }
            case "osszesOsztaly": {
                $helyettesitesek = new Helyettesitesek();
                echo $helyettesitesek->osszesOsztaly();
                break;
            }
            case "kereses": {
                $teke = new Helyettesitesek();
                echo $teke->versenyzoKeres($this->erkezettAdatok->nev);
                break;
            }
            default: {
                echo "Alapméretezett";
                break;
            }
        }
    }
}

?>