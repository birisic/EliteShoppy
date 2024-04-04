<?php
    function registerInputsCheck($firstName, $lastName, $email, $password, $passwordConfirm){
        global $conn;

        $reFullName = "/^([A-ZŠČĆĐŽ][a-zščćđž]{2,14}){1,3}$/";
        $rePassword = "/^[A-Za-z\d]{8,20}$/";//(?=.*[A-Za-z])(?=.*\d)

        $errors = [];

        #KRIPTUJ SIFRU!

        if (!preg_match($reFullName, $firstName)){
            $errors[] = "Ime mora sadržati bar jedno veliko slovo i maksimum 15 malih.";
        }
        if (!preg_match($reFullName, $lastName)) {
            $errors[] = "Prezime mora sadržati bar jedno veliko slovo i maksimum 15 malih.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Email nije u dobrom formatu. Primer: username@gmail.com...";
        } else {
            $query = "SELECT COUNT(*) as count FROM users WHERE email = '$email'";
            $result = $conn->query($query)->fetch();
            if ($result->count > 0) {
                $errors[] = "Email je već u upotrebi!";
            }
        }
        if (!preg_match($rePassword, $password)) {
            $errors[] = "Lozinka mora sadržati 8-20 karaktera i to samo slova i brojeve.";
        }
        else {
            if ($passwordConfirm != $password) {
                $errors[] = "Lozinke nisu iste!";
            }
        }

        return $errors;
    }

    function logIn($email, $password){
        global $conn;

        $hashPassword = md5($password . "conststring");

        $query = $conn->prepare("SELECT u.id, u.first_name, u.last_name, u.email, r.role FROM users u INNER JOIN roles r ON u.role_id = r.id WHERE u.email = :email AND u.password = :hashPassword");

        $query->bindParam(":email", $email);
        $query->bindParam(":hashPassword", $hashPassword);

        $query->execute();

        $result = $query->fetch();

        return $result;
    }

    function loginInputsCheck($email, $password){
        $rePassword = "/^[A-Za-z\d]{8,20}$/";

        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email nije u dobrom formatu. Primer: username@gmail.com...";
        }

        if (!preg_match($rePassword, $password)) {
            $errors[] = "Lozinka mora sadržati 8-20 karaktera i to samo slova i brojeve.";
        }
        return $errors;
    }

    function contactInputsCheck($name, $email) {
        $reName = "/^([A-ZŠČĆĐŽ][a-zščćđž]{2,14}){1,3}$/";

        $errors = [];

        if (!preg_match($reName, $name)) {
            $errors[] = "Ime mora sadržati bar jedno veliko slovo i maksimum 15 malih.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Email nije u dobrom formatu. Primer: username@gmail.com...";
        }

        return $errors;
    }

    function printNavigation(){
        global $conn;

        $query = "SELECT * FROM `navigation`";

        $result = $conn->query($query)->fetchAll();

        return $result;
    }


    function getAll($table){
        global $conn;

        $query = $conn->prepare("SELECT * FROM $table");
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    function insertArticle($name,$tag,$IDcat){
        global $conn;

        $sql = "INSERT INTO articles (name, tag, IDcat)
                    VALUES (:name, :tag, :IDcat);";

        $query = $conn->prepare($sql);
        $query->bindParam(":name", $name);
        $query->bindParam(":tag",$tag);
        $query->bindParam(":IDcat",$IDcat);

        $result = $query->execute();

        return $result;
    }

    function insertCategory($categoryName) {
        global $conn;

        $sql = "INSERT INTO categories (name)
                    VALUES (:categoryName);";

        $query = $conn->prepare($sql);
        $query->bindParam(":categoryName", $categoryName);

        $result = $query->execute();

        return $result;
    }

    function insertArticleGender($IDarticle,$IDgender,$priceNew,$priceOld,$description,$image){
        global $conn;
        $result = "";
        $sql = "INSERT INTO articles_genders (IDarticle, IDgender, priceNew, priceOld, description, image)
                    VALUES (:IDarticle,:IDgender,:priceNew,:priceOld,:description,:image);";

        $query = $conn->prepare($sql);
        $query->bindParam(":IDarticle", $IDarticle);
        $query->bindParam(":IDgender", $IDgender);
        $query->bindParam(":priceNew", $priceNew);
        $query->bindParam(":priceOld", $priceOld);
        $query->bindParam(":description", $description);
        $query->bindParam(":image", $image);

        try {
            $result = $query->execute();
        }
        catch (PDOException $e){

        }

        return $result;
    }

    function deleteRow($table, $id){
        global $conn;

        $sql = "DELETE FROM " . $table. " WHERE id = :id";

        $query = $conn->prepare($sql);
        $query->bindParam(":id", $id);

        $query->execute();

        $rowCount = $query->rowCount();

        return $rowCount;
    }

    function findRecord($table, $id){
        global $conn;

        $sql = "SELECT * FROM " . $table . " WHERE id = :id";

        $query = $conn->prepare($sql);
        $query->bindParam(":id", $id);

        $query->execute();

        $result = $query->fetch();

        return $result;
    }
?>
