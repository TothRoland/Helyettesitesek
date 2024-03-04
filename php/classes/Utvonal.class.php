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
            case "bejelentkezes": {
                $helyettesitesek = new Helyettesitesek();
                echo $helyettesitesek->bejelentkezes($this->erkezettAdatok);
                break;
            }
            case "regisztracio": {
                $helyettesitesek = new Helyettesitesek();
                echo $helyettesitesek->regisztracio($this->erkezettAdatok);
                break;
            }
            case "adminverify" : {
                $helyettesitesek = new Helyettesitesek();
                echo $helyettesitesek->adminverify();
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