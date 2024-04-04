<?php
    session_start();
    include "utility.php";
    include "../config/conn.php";
    include "functions.php";

    if (!isset($_SESSION['user']) || $_SESSION['user']->role != "admin") {
        redirect("../index.php?page=profile");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $categoryName = $_POST['categoryName'];

        $errors = [];
        #PROVERA
        if (empty($categoryName)){
            $errors[] = "Naziv kategorije ne sme biti prazan!";
        }

        if (count($errors) == 0){
            if ($conn){
                $insert = insertCategory($categoryName);

                if ($insert){
                    $result = ["message" => "Kategorija uspešno dodata."];
                    $status = 201;//Created
                }
                else {
                    $errors[] = "Greška prilikom unosa.";
                    $result = ["errors" => $errors];
                    $status = 500;//Internal server error
                }

                http_response_code($status);
                echo json_encode($result);
            }
            else {
                echo $result = ["message" => "Nema konekcije sa bazom."];
            }
        }
        else {
            $result = ["errors" => $errors];
            http_response_code(406);//Not acceptable
            echo json_encode($result);
        }
    }
    else {
        redirect("../index.php?page=about");
    }
?>

