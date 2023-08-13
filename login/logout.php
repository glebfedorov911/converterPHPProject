<?php

    $root = $_SERVER["DOCUMENT_ROOT"];

    session_start();
    require $root . "/other/other.php";

    $opt = ["usernameError", "passwordError", "password", "username"];

    checkSession($opt);

    setcookie("username", $_SESSION["username"], time()-360000000, "/");

    header("Location: ../main.php");