<?php
session_start();
include "utility.php";
include "../config/conn.php";
include "functions.php";

header("Content-type: application/json");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $name = $_POST['contactName'];
        $email = $_POST['contactEmail'];
        $subject = $_POST['contactSubject'];
        $message = $_POST['contactMessage'];


        #VALIDATE LOGIN INPUTS
        $errors = contactInputsCheck($name, $email);
        if(count($errors) > 0){
            $result = ["message" => "Ima grešaka u unosu podataka.",
                        "errors" => $errors];
            http_response_code(401);
            echo json_encode($result);
            die;
        }
        else {
            //SEND EMAIL
            if (mail("birisicmartin02@gmail.com", $subject, $message)){
                http_response_code(200);
                $result = ["message" => "Poruka uspešno poslata."];
                echo json_encode($result);
            }
            else {
                $errors[] = "Greška u slanju poruke.";
                http_response_code(500);
                $errors = ["errors" => $errors];
                echo json_encode($errors);
            }
        }
    }
    else{
        redirect("../index.php?page=about");
    }
?>
