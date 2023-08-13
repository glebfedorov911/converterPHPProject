<?php
    $mysqli = new mysqli("localhost", "root", "", "mydb", 1234);

    function mysqlQuery($sql, $link) {
        try {
            mysqli_query($sql, $link);
        }
        catch (\mysql_xdevapi\Exception) {
            echo "ОШИБКА";
        }
    }

//    $createTable_User = "CREATE TABLE IF NOT EXISTS `user` (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(30) UNIQUE NOT NULL, password TEXT NOT NULL)";
    $createTable_User = "CREATE TABLE IF NOT EXISTS `conv` (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, user INT, currency VARCHAR(10) NOT NULL, inV INT NOT NULL, outV INT NOT NULL, FOREIGN KEY (user) REFERENCES user(id))";

    mysqlQuery($mysqli, $createTable_User);