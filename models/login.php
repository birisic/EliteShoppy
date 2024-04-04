<?php
    session_start();
    include "utility.php";
    include "../config/conn.php";
    include "functions.php";

    #URL PROTECTION
    if (isset($_SESSION['user'])) {
        redirect("../index.php?page=profile");
    }

    header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == "POST"){//isset($_POST['btn-login'])
        $email = $_POST['loginEmail'];
        $password = $_POST['loginPassword'];

        if ($conn) {
            #VALIDATE LOGIN INPUTS
            $errors = loginInputsCheck($email, $password);
            if(count($errors) > 0){
                http_response_code(401);
                $result = ["message" => "Ima grešaka u unosu podataka.",
                    "errors" => $errors];
                echo json_encode($result);
                die;
            }
            else {
                //FIND THIS USER AND LOGIN
                $loggedUser = logIn($email, $password);
                if ($loggedUser) {
                    $_SESSION['user'] = $loggedUser;

                    if ($loggedUser->role == "buyer") {
                        http_response_code(200);
                        $result = ["message" => "Uspešno logovanje."];
                        echo json_encode($result);
                    }
                     else {
                         //ADMIN
                         http_response_code(200);
                         $result = ["message" => "Uspešno ste se ulogovali."];
                         echo json_encode($result);
                     }
                }
                else {
                    http_response_code(404);
                    $errors[] = "Greška u logovanju.";
                    $errors = ["errors" => $errors];
                    echo json_encode($errors);
                }
            }
        }
        else {
            echo $result = ["message" => "Nema konekcije sa bazom."];
        }
    }
    else{
        redirect("../index.php?page=about");
    }
?>