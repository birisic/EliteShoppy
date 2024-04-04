<?php


session_start();
include "utility.php";
include "../config/conn.php";
include "functions.php";

if (!isset($_SESSION['user']) || $_SESSION['user']->role != "admin") {
    redirect("../index.php?page=profile");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $IDarticle = $_POST['IDarticle'];
    $IDgender = $_POST['IDgender'];
    $priceNew = $_POST['priceNew'];
    $priceOld = $_POST['priceOld'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $errors = [];
    #PROVERA
    if (empty($priceNew) || $priceNew <= 0 || $priceOld <= 0) {
        $errors[] = "Cena mora biti pozitivan broj!";
    }
    if (empty($priceOld)) {
        $priceOld = NULL;
    }
    if (empty($description)) {
        $errors[] = "Opis artikla mora postojati!";
    }
    if (empty($image)) {
        $errors[] = "Putanja do slike artikla mora postojati!";
    }

    if (count($errors) == 0) {
        if ($conn) {
            $sql = "UPDATE articles_genders 
                    SET IDarticle = :IDarticle, IDgender = :IDgender, priceNew = :priceNew,
                        priceOld = :priceOld, description = :description, image = :image
                    WHERE id = :id;";

            $query = $conn->prepare($sql);

            $query->bindParam(":id", $id);
            $query->bindParam(":IDarticle", $IDarticle);
            $query->bindParam(":IDgender", $IDgender);
            $query->bindParam(":priceNew", $priceNew);
            $query->bindParam(":priceOld", $priceOld);
            $query->bindParam(":description", $description);
            $query->bindParam(":image", $image);

            $result = $query->execute();

            if ($result) {
                $result = ["message" => "Dodatne informacije o artiklu su uspešno izmenjene u bazi."];
                $status = 201;//Created
            } else {
                $errors[] = "Greška prilikom unosa (Kombinacija izabranih vrednosti za artikal i pol možda već postoji).";
                $result = ["errors" => $errors];
                $status = 500;//Internal server error
            }

            http_response_code($status);
            echo json_encode($result);
        } else {
            echo $result = ["message" => "Nema konekcije sa bazom."];
        }
    } else {
        $result = ["errors" => $errors];
        http_response_code(406);//Not acceptable
        echo json_encode($result);
    }
} else {
    redirect("../index.php?page=about");
}
?>