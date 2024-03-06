<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

class Helyettesitesek {
    public function osszesTanar() {
        $sqlMuvelet = "SELECT * FROM tanarok ORDER BY tanarnev";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function osszesOsztaly() {
        $sqlMuvelet = "SELECT * FROM osztalyok";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function bejelentkezes($erkezettAdatok) {
        if($erkezettAdatok->felhasznalonev == null || $erkezettAdatok->jelszo == null) {
            return json_encode(array("valasz" => "Nem adott meg minden adatot!"), JSON_UNESCAPED_UNICODE);
        }
        $sqlMuvelet = "SELECT * FROM felhasznalok WHERE felhasznalonev = '{$erkezettAdatok->felhasznalonev}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        $sqlEredmenyJelszo = $sqlEredmeny[0]['jelszo'] ?? null;
        if($sqlEredmenyJelszo == null) {
            $this->sessionLeallitas();
            return json_encode(array("valasz" => "Sikertelen bejelentkezés!"), JSON_UNESCAPED_UNICODE);
        }
        if (password_verify($erkezettAdatok->jelszo, $sqlEredmeny[0]['jelszo'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
                $_SESSION['felhasznalonev'] = $sqlEredmeny[0]['felhasznalonev'];
                $_SESSION['email'] = $sqlEredmeny[0]['email'];
                $_SESSION['admin'] = $sqlEredmeny[0]['role'];
                $valasz = array("valasz" => "Sikeres bejelentkezés!");
            }
            else {
                $this->sessionLeallitas();
                $valasz = array("valasz" => "Sikertelen bejelentkezés!");
            }
        } else {
            $this->sessionLeallitas();
            $valasz = array("valasz" => "Sikertelen bejelentkezés!");
        }
        return json_encode($valasz, JSON_UNESCAPED_UNICODE);
    }

    public function regisztracio($erkezettAdatok) {
        if($erkezettAdatok->felhasznalonev == null || $erkezettAdatok->jelszo1 == null || $erkezettAdatok->jelszo2 == null || $erkezettAdatok->email == null || $erkezettAdatok->szerepkorid == null) {
            return json_encode(array("valasz" => "Nem adott meg minden adatot!"), JSON_UNESCAPED_UNICODE);
        }
        $sqlMuvelet = "SELECT * FROM felhasznalok WHERE felhasznalonev = '{$erkezettAdatok->felhasznalonev}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        $valasz = $sqlEredmeny[0] ?? null;
        if($valasz != null) {
            return json_encode(array("valasz" => "A felhasználónév foglalt!"), JSON_UNESCAPED_UNICODE);
        }
        if(strlen($erkezettAdatok->jelszo1) < 8 || strlen($erkezettAdatok->jelszo2) < 8) {
            return json_encode(array("valasz" => "A jelszavak minimum 8 karakter hosszúak legyenek!"), JSON_UNESCAPED_UNICODE);
        }
        if($erkezettAdatok->jelszo1 != $erkezettAdatok->jelszo2) {
            return json_encode(array("valasz" => "A jelszó nem egyezik!"), JSON_UNESCAPED_UNICODE);
        }
        if(!filter_var($erkezettAdatok->email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(array("valasz" => "Az email nem megfelelő!"), JSON_UNESCAPED_UNICODE);
        }
        $titkositottJelszo = password_hash($erkezettAdatok->jelszo1, PASSWORD_DEFAULT);
        $verify = md5(rand());
        if($erkezettAdatok->szerepkor == "diak") {
            $sqlMuvelet = "INSERT INTO felhasznalok (felhasznalonev, email, jelszo, osztalyId, tanarId, verify) VALUES ('{$erkezettAdatok->felhasznalonev}', '{$erkezettAdatok->email}', '{$titkositottJelszo}', '{$erkezettAdatok->szerepkorid}', '0', '{$verify}');";
        } else {
            $sqlMuvelet = "INSERT INTO felhasznalok (felhasznalonev, email, jelszo, osztalyId, tanarId, verify) VALUES ('{$erkezettAdatok->felhasznalonev}', '{$erkezettAdatok->email}', '{$titkositottJelszo}', '0', '{$erkezettAdatok->szerepkorid}', '{$verify}');";
        }
        $sqlEredmeny = Adatbazis::adatValtoztatas($sqlMuvelet);
        $emailbody = "
        <h2> Köszöntünk az Ipari Helyettesítések oldalán, {$erkezettAdatok->felhasznalonev}!</h2>
        <h4> Utolsó lépésként erősítsd meg az email-címed az alábbi linken, hogy véglegesítsd a regisztrációdat: </h4>
        <a href='http://localhost/13c-toth/Z%C3%A1r%C3%B3dolgozat/php/verify.php?felhasznalonev={$erkezettAdatok->felhasznalonev}&verify={$verify}'><h2>Véglegesítés</h2></a>
        ";
        $mail = $this->sendMail($erkezettAdatok->email, $emailbody);
        if($mail == "Sikeres email elküldés!") {
            return json_encode(array("valasz" => "Sikeres regisztráció!"), JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(array("valasz" => "Sikertelen regisztráció!"), JSON_UNESCAPED_UNICODE);
        }
    }

    public function szerepkor($erkezettAdatok){
        if($erkezettAdatok->diaktanar == "diak") {
            $adatok = $this->osszesOsztaly();
        } else {
            $adatok = $this->osszesTanar();
        }
        return $adatok;
    }

    public function adminverify() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['admin'])) {
            if ($_SESSION['admin'] == 0) {
                header("Location: ../../index.html");
            } else {
                return json_encode(array("valasz" => "Jogosult az oldalhoz!"), JSON_UNESCAPED_UNICODE);
            }
        } else {
            header("Location: ../../index.html");
        }
    }

    public function feltoltes($erkezettAdatok) {
        $target_dir = "../../feltoltottFajlok/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
        }
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        if ($_FILES["fileToUpload"]["size"] > 50000000) {
            $uploadOk = 0;
        }
    }

    public function sessionLeallitas(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['felhasznalonev'])) {
            $_SESSION['felhasznalonev'] = null;
            unset($_SESSION['felhasznalonev']);
        }
        if (isset($_SESSION['email'])) {
            $_SESSION['email'] = null;
            unset($_SESSION['email']);
        }
        if (isset($_SESSION['admin'])) {
            $_SESSION['admin'] = null;
            unset($_SESSION['admin']);
        }
        session_destroy();
    }

    public function sendMail($email, $body) {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = 3;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = 0;
            $mail->Username = 'helyettesitesek.vszcipari@gmail.com';
            $mail->Password = 'rlhkojftskbybxza';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->AuthType = 'LOGIN';
            $mail->setFrom($mail->Username, "Helyettesitesek");
            $mail->addAddress($email);
           
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Helyettesítések - Fiók-megerősítés';
            $mail_template = $body;
            $mail->Body = $mail_template;
            $mail->send();
            return "Sikeres email elküldés!";
        } catch (Exception $e) {
            return "Hiba az üzenet elküldésekor. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>