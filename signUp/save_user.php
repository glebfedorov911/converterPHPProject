<?php

    $root = $_SERVER["DOCUMENT_ROOT"];

    require $root . "/other/other.php";

    if (empty($_COOKIE["username"])) {

        session_start();

        $_SESSION["username"] = $_POST["username"];
        $_SESSION["password"] = $_POST["password"];

        $_SESSION["usernameError"] = '';
        $_SESSION["passwordError"] = '';

        if (htmlspecialchars(trim($_SESSION["username"])) == "") {
            $_SESSION["usernameError"] = "Некорректное имя пользователя";
            redirect("signUp.php");
        }
        elseif (strlen(htmlspecialchars(trim($_SESSION["username"]))) < 5) {
            $_SESSION["usernameError"] = "Ваш логин слишком короткий (5 и более символов)";
            redirect("signUp.php");
        }

        if (strlen($_SESSION["password"]) < 8) {
            $_SESSION["passwordError"] = "Ваш пароль слишком короткий (8 и более символов)";
            redirect("signUp.php");
        }

        if (empty($_SESSION["passwordError"]) && empty($_SESSION["usernameError"])) {
            require "C:\Users\User\PhpstormProjects\converterFirstProject\db.php";

            $mysqli = new mysqli("localhost", "root", "", "mydb", 1234);

            $u = $_SESSION['username'];
            $p = sha1($_SESSION['password']);

            $addNewNode = "INSERT INTO `user` (username, password) VALUES ('$u', '$p')";

            try {
                mysqlQuery($mysqli, $addNewNode);
                setcookie("username", $_SESSION["username"], time()+3600, "/");
            }
            catch (Exception) {
                echo "bad request";
                $_SESSION["usernameError"] = "Данный логин занят";
                redirect("signUp.php");
            }
        }
    }

    header("Location: ../main.php");