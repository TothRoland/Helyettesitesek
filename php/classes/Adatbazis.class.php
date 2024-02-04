<?php

//Statikus tulajdonságokkal és metódusokkal rendelkező osztály:
class Adatbazis {
    private static $kiszolgalo = "localhost";
    private static $felhasznalo = "root";
    private static $jelszo = "";
    private static $tabla = "helyettesitesek";
    private static $db;

    //Adatok lekérése az adatbázisból:
    public static function adatLekeres($muvelet) {
        self::$db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);

        if(self::$db->connect_errno == 0) {
            $eredmeny = self::$db->query($muvelet);
            if(self::$db->errno == 0) {
                if($eredmeny->num_rows > 0) {
                    $adatok = $eredmeny->fetch_all(MYSQLI_ASSOC);
                }
                else {
                    $adatok = array("valasz" => "Nincs találat!");
                }
            }
            else {
                $adatok = array("valasz" => self::$db->error);
            }
        }
        else {
            $adatok = array("valasz" => self::$db->connect_error);
        }

        return $adatok;
    }

    //Adatok változtatása az adatbázisban:
    public static function adatValtoztatas($muvelet) {
        self::$db = new mysqli(self::$kiszolgalo, self::$felhasznalo, self::$jelszo, self::$tabla);

        if(self::$db->connect_errno == 0) {
            $eredmeny = self::$db->query($muvelet);
            if(self::$db->errno == 0) {
                if(self::$db->affected_rows > 0) {
                    $adatok = array("valasz" => "Sikeres művelet!");
                }
                else {
                    $adatok = array("valasz" => "Sikertelen művelet!");
                }
            }
            else {
                $adatok = array("valasz" => self::$db->error);
            }
        }
        else {
            $adatok = array("valasz" => self::$db->connect_error);
        }

        return $adatok;
    }
}

?>