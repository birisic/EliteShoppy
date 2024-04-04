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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            else{
                $hashPassword = md5($password . "conststring");
                //upit za bazu
                $query = $conn->prepare("INSERT INTO users (first_name,last_name,email,password,date_added) VALUES (:first_name, :last_name, :email, :hashPassword, now())");

                //parameters
                $query->bindParam(':first_name', $firstName);
                $query->bindParam(':last_name', $lastName);
                $query->bindParam(':email', $email);
                $query->bindParam(':hashPassword', $hashPassword);

                $query->execute();//$result =

                //FIND THIS USER AND LOGIN
                $loggedUser = logIn($email, $password);

                if ($loggedUser) {
                    $_SESSION['user'] = $loggedUser;

                    if ($loggedUser->role == "buyer") {
                        http_response_code(200);
//                        redirect("../index.php?page=about");
                        $result = ["message" => "Uspešan unos."];
                        echo json_encode($result);
                    }
                }
                else {
                    http_response_code(404);
                    $errors[] = "Greška u registraciji.";
                    $errors = ["errors" => $errors];
                    echo json_encode($errors);
                }


            }
        }
        else {
            echo $result = ["message" => "Nema konekcije sa bazom."];
        }
    }else {
        redirect("../index.php?page=about");
    }
?>
