<?php
    session_start();
    include "utility.php";
    include "../config/conn.php";
    include "functions.php";

    if (!isset($_SESSION['user']) || $_SESSION['user']->role != "admin") {
        redirect("../index.php?page=profile");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $tag = $_POST['tag'];
        $IDcat = $_POST['IDcat'];

        $errors = [];
        #PROVERA
        if (empty($name)){
            $errors[] = "Naziv ne sme biti prazan!";
        }
        if (empty($tag)){
            $tag = NULL;
        }
        if (count($errors) == 0){
            if ($conn){
                $insert = insertArticle($name,$tag,$IDcat);

                if ($insert){
                    $result = ["message" => "Artikal uspešno dodat."];
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
