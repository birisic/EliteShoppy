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
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPass = $_POST['passwordConfirm'];


    if ($conn) {
        $errors = registerInputsCheck($firstName, $lastName, $email, $password, $confirmPass);

        if(count($errors) > 0){
            http_response_code(401);//unauthorized
            $result = ["message" => "Ima grešaka u unosu podataka.",
                "errors" => $errors];
            echo json_encode($result);
            die;
        }
        else {
            $hashPassword = md5($password . "conststring");
            //upit za bazu
            $query = $conn->prepare("UPDATE users
                                           SET first_name = :first_name,last_name = :last_name,email = :email,password = :hashPassword
                                           WHERE id = :id");

            //parameters
            $query->bindParam(':id', $id);
            $query->bindParam(':first_name', $firstName);
            $query->bindParam(':last_name', $lastName);
            $query->bindParam(':email', $email);
            $query->bindParam(':hashPassword', $hashPassword);

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
