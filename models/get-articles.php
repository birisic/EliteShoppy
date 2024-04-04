<?php
session_start();
include "utility.php";
include "../config/conn.php";
include "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $inputSearch = isset($_GET['inputSearch']) ? $_GET['inputSearch'] : '';
    $inputPrice = isset($_GET['inputPrice']) ? $_GET['inputPrice'] : '';
    $inputSort = isset($_GET['inputSort']) ? $_GET['inputSort'] : '1';
    $inputCategory = isset($_GET['inputCategory']) ? $_GET['inputCategory'] : '';
    $inputGender = isset($_GET['inputGender']) ? $_GET['inputGender'] : '';

    $errors = [];
//    ag.id
    $sql = "SELECT ag.id AS 'ag_id', a.id, a.name AS 'article_name', a.IDcat, a.tag, g.id AS 'IDgender', g.name AS 'gender', CONCAT('$', ag.priceNew) AS 'active_price',
            CONCAT('$', ag.priceOld) AS 'old_price', ag.description, ag.image
            FROM articles_genders ag
            JOIN articles a ON ag.IDarticle = a.id
            JOIN genders g ON ag.IDgender = g.id
            WHERE 1=1";

    $params = [];

    if (!empty($inputSearch)) {
        $sql .= " AND a.name LIKE :inputSearch";
        $params[':inputSearch'] = '%' . $inputSearch . '%';
    }

    if (!empty($inputGender)) {
        $sql .= " AND g.id = :inputGender";
        $params[':inputGender'] = $inputGender;
    }

    if (!empty($inputCategory)) {
        $sql .= " AND a.IDcat = :inputCategory";
        $params[':inputCategory'] = $inputCategory;
    }

    if (!empty($inputPrice)) {
        $sql .= " AND ag.priceNew <= :inputPrice";
        $params[':inputPrice'] = $inputPrice;
    }

    if ($inputSort === '1') {
        $sql .= " ORDER BY a.name ASC";
    }
    else if ($inputSort === '2') {
        $sql .= " ORDER BY a.name DESC";
    }
    else if ($inputSort === '3') {
        $sql .= " ORDER BY ag.priceNew DESC";
    }
    else {
        $sql .= " ORDER BY ag.priceNew ASC";
    }

    $query = $conn->prepare($sql);

    foreach ($params as $param=>&$value) {//&
        $query->bindParam($param,$value);
    }

    $query->execute();

    if ($query->rowCount() > 0) {
        $result = $query->fetchAll();
        http_response_code(202);
        echo json_encode($result);
    } else {
        $errors[] = "Nijedan artikal nije pronadjen.";
        $result = ["message" => "Ima grešaka.",
                    "errors" => $errors];
        http_response_code(404);
        echo json_encode($result);
    }
}
else {
    redirect("../index.php?page=about");
}
?>
