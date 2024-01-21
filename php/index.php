<?php

$url = explode('/', $_SERVER['REQUEST_URI']);
$urlEnd = end($url);

$erkezett = file_get_contents("php://input");
$adatok = json_decode($erkezett,true);
$pass = $adatok["jelszo"] ?? null;


switch($urlEnd){
    case "login":
    {
        echo jelszoFeltoltesEllenorzes($pass);
        break;
    }
    default:
    {
        echo "Alapméretezett";
        break;
    }
}

function lekerdezes($muvelet) {
    $db=new mysqli ('localhost','root','','helyettesitesek');
    if($db->connect_errno == 0) {
        $eredmeny = $db->query($muvelet);
        if($db->errno == 0) {
            if($eredmeny->num_rows > 0) {
                $valasz = $eredmeny->fetch_all(MYSQLI_ASSOC);
            } else {
                $valasz = array("valasz"=>"Sikertelen");
            }
        } else {
            $valasz = array("valasz"=>$db->error);
        }
    } else {
        $valasz = array("valasz"=>$db->connect_error);
    }
    $conn->close();
    return json_encode($valasz,JSON_UNESCAPED_UNICODE);
}

//Nincs kész!!!
function feltoltes($muvelet) {
    $db=new mysqli ('localhost','root','','helyettesitesek');
    if($db->connect_errno == 0) {
        $eredmeny = $db->query($muvelet);
        if($db->errno == 0) {
            if($db->affected_rows > 0) {
                $valasz = array("valasz"=>"Sikeres");
            } else {
                $valasz = array("valasz"=>"Sikertelen");
            }
        } else {
            $valasz = array("valasz"=>$db->error);
        }
    } else {
        $valasz = array("valasz"=>$db->connect_error);
    }
    $conn->close();
    return json_encode($valasz,JSON_UNESCAPED_UNICODE);
}

function jelszoFeltoltesEllenorzes($jelszo){
    $options = ['cost' => 12];
    $hashedPassword = password_hash($jelszo, PASSWORD_BCRYPT, $options);
    //return json formátumban kell!!!
    if(password_verify($jelszo,$hashedPassword)){
        return 'Hashed Password: ' . $hashedPassword . PHP_EOL;
    }
    return ' ' . $hashedPassword . PHP_EOL;
}
?>