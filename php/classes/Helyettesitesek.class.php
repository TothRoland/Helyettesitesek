<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

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

    public function bejelentkezes($erkezettAdatok) {
        $sqlMuvelet = "SELECT * FROM felhasznalok WHERE felhasznalonev = '{$erkezettAdatok->felhasznalonev}'";
        $sqlEredmeny = Adatbazis::adatLekeres($sqlMuvelet);
        if (password_verify($erkezettAdatok->jelszo, $sqlEredmeny[0]['jelszo'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
                $_SESSION['felhasznalonev'] = $sqlEredmeny[0]['felhasznalonev'];
                $_SESSION['email'] = $sqlEredmeny[0]['email'];
                $_SESSION['admin'] = $sqlEredmeny[0]['role'];
                $valasz = array("valasz" => "Sikeres bejelentkezés!");
            }
            else {
                $valasz = array("valasz" => "Sikertelen bejelentkezés!");
            }
        } else {
            session_abort();
            $valasz = array("valasz" => "Sikertelen bejelentkezés!");
        }
        return json_encode($valasz, JSON_UNESCAPED_UNICODE);
    }

    public function regisztracio($erkezettAdatok) {
        $titkositottJelszo = password_hash($erkezettAdatok->jelszo, PASSWORD_DEFAULT);
        $verify = md5(rand());
        $sqlMuvelet = "INSERT INTO felhasznalok (felhasznalonev, email, jelszo, osztalyId, tanarId, verify) VALUES ('{$erkezettAdatok->felhasznalonev}', '{$erkezettAdatok->email}', '{$titkositottJelszo}', '0', '0', '{$verify}');";
        $sqlEredmeny = Adatbazis::adatValtoztatas($sqlMuvelet);
        $this->sendMail($erkezettAdatok->felhasznalonev, $erkezettAdatok->email, $verify);
        return json_encode($sqlEredmeny, JSON_UNESCAPED_UNICODE);
    }

    public function adminverify() {
        if (isset($_SESSION['admin'])) {
            if ($_SESSION['admin'] == 0) {
                return json_encode(array("valasz" => "../index.html"), JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(array("valasz" => "Jogosult az oldalhoz!"), JSON_UNESCAPED_UNICODE);
            }
        } else {
            return json_encode(array("valasz" => "../index.html"), JSON_UNESCAPED_UNICODE);
        }
    }

    public function sendMail($user, $email, $verify) {
        $mail = new PHPMailer(true);
        try {
            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = 3;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
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
            $mail_template = "
            <h2> Köszöntünk az Ipari Helyettesítések oldalán, $user!</h2>
            <h4> Utolsó lépésként erősítsd meg az email-címed az alábbi linken, hogy véglegesítsd a regisztrációdat: </h4>
            <a href='http://localhost/php/Z%C3%A1r%C3%B3dolgozat/php/verify.php?felhasznalonev={$user}&verify={$verify}'><h2>Véglegesítés</h2></a>
            ";
            $mail->Body = $mail_template;
            $mail->send();
            return json_encode(array("valasz" => "Sikeres email elküldés!"), JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo "Hiba az üzenet elküldésekor. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>