<?php
session_start();
include "utility.php";
include "../config/conn.php";
include "functions.php";

if (!isset($_SESSION['user']) || $_SESSION['user']->role != "admin") {
    redirect("../index.php?page=profile");
}

header("Content-type: application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table = $_POST['tableName'];
    $id = $_POST['id'];

    if ($conn){

        $result = [];
        $deletedRowCount = deleteRow($table, $id);

        if ($deletedRowCount > 0){
            #GET REFRESHED ROWS
            $sql = "SELECT u.id, u.first_name, u.last_name, u.email, u.password, r.role, u.date_added
              FROM users u
              JOIN roles r ON u.role_id = r.id;";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $status = 200;
        }
        else {
            $errors[] = "Greška prilikom brisanja.";
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
    redirect("../index.php?page=about");
}

?>
