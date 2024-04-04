<?php
    session_start();
    include "utility.php";
    include "../config/conn.php";
    include "functions.php";

    if (!isset($_SESSION['user']) || $_SESSION['user']->role != "admin") {
        redirect("../index.php?page=profile");
    }

    header("Content-type: application/json");
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $table = $_GET['table'];

        if ($conn){
            switch ($table) {
                case 'users':
                    $sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.password, r.role, u.date_added
                              FROM users u
                              JOIN roles r ON u.role_id = r.id;";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $result = $query->fetchAll();

                    http_response_code(200);
                    echo json_encode($result);
                    break;
                case 'articles':
                    $sql = "SELECT a.id, a.name, a.tag, c.name AS 'category'
                            FROM articles a
                            JOIN categories c
                            ON a.IDcat = c.id";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $result = $query->fetchAll();

                    http_response_code(200);
                    echo json_encode($result);

                    break;
                case 'categories':
                    $result = getAll($table);

                    http_response_code(200);
                    echo json_encode($result);

                    break;
                case 'articles_genders':
                    $sql = "SELECT ag.id, a.name AS 'article name', g.name AS 'gender', CONCAT('$', ag.priceNew) AS 'active price', CONCAT('$', ag.priceOld) AS 'old price', ag.description, ag.image AS 'image path'
                            FROM articles_genders ag
                            JOIN articles a ON ag.IDarticle = a.id
                            JOIN genders g ON ag.IDgender = g.id";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $result = $query->fetchAll();

                    http_response_code(200);
                    echo json_encode($result);

                    break;
                case 'genders':
                    $result = getAll($table);

                    http_response_code(200);
                    echo json_encode($result);

                    break;
                default:
                    $errors[] = "Error while retrieving data...";
                    $result = ["errors" => $errors];
                    http_response_code(404);
                    echo json_encode($result);
                    break;
            }
        }
        else {
            echo $result = ["message" => "Nema konekcije sa bazom."];
        }
    }
        else {
            redirect("../index.php?page=about");
        }

?>
