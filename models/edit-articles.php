<?php
session_start();
include "utility.php";
include "../config/conn.php";
include "functions.php";

#URL PROTECTION
if (!isset($_SESSION['user']) || $_SESSION['user']->role != "admin") {
    redirect("../index.php?page=profile");
}

header("Content-type: application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $tag = $_POST['tag'];
    $IDcat = $_POST['IDcat'];

    $errors = [];

    if (empty($name)){
        $errors[] = "Naziv ne sme biti prazan!";
    }
    if (empty($tag)){
        $tag = NULL;
    }

    if ($conn) {
        if(count($errors) > 0){
            http_response_code(401);//unauthorized
            $result = ["message" => "Ima grešaka u unosu podataka.",
                "errors" => $errors];
            echo json_encode($result);
            die;
        }
        else {
            $sql = "UPDATE articles SET name = :name, tag = :tag, IDcat = :IDcat
                    WHERE id = :id;";

            $query = $conn->prepare($sql);
            $query->bindParam(":id", $id);
            $query->bindParam(":name", $name);
            $query->bindParam(":tag",$tag);
            $query->bindParam(":IDcat",$IDcat);

            $result = $query->execute();

            http_response_code(200);
            $result = ["message" => "Uspešna promena u bazi."];
            echo json_encode($result);
        }
    }
    else {
        echo $result = ["message" => "Nema konekcije sa bazom."];
    }
}else {
    redirect("../index.php?page=about");
}
?>
