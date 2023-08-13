<?php
    $root = $_SERVER["DOCUMENT_ROOT"];

    require $root . "/other/other.php";

    session_start();

    if (empty($_COOKIE["username"])) {

        $_SESSION["usernameError"] = "";
        $_SESSION["passwordError"] = "";

        $_SESSION["username"] = $_POST["username"];
        $_SESSION["password"] = $_POST["password"];

        $_u = $_SESSION["username"];

        $mysqli = new mysqli("localhost", "root", "", "mydb", 1234);
        $result = mysqli_query($mysqli, "SELECT password FROM `user` WHERE username = '{$_u}'");

        $data = mysqli_fetch_array($result);

        if ($data == "") {
            $_SESSION["usernameError"] = "Вы ввели не существующее имя";
            header("Location: login.php");
        }
        elseif ($data[0] != sha1($_SESSION["password"])) {
            $_SESSION["passwordError"] = "Вы ввели неверный пароль";
            header("Location: login.php");
        }
        else {
            setcookie("username", $_SESSION["username"], time() + 3600, "/");
            header("Location: ../main.php");
        }
    }
    else {
        header("Location: ../main.php");
    }

