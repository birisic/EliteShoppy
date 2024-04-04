<?php
    $host = "localhost";
    $database = "elite-shop";
    $server = "mysql";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO($server.":host=".$host.";dbname=".$database.";charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
    catch (PDOException $ex) {
        echo $ex->getMessage();
    }
?>
