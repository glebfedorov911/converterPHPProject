<?php

    $root = $_SERVER["DOCUMENT_ROOT"];

    require $root . "/other/other.php";

    session_start();

    function getCourse($oC, $iC) {
        $key = "";
        $url = "https://currate.ru/api/?get=rates&pairs=$iC$oC&key=$key"; // Курсы старые 2018-19 год (в будущем можно менять)


        if ($oC == $iC) {
            return 1;
        }

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $output = explode('\"', json_encode(curl_exec($ch), true));

        curl_close($ch);

        return $output[11];

    }

    function convert($iV, $oC, $iC){
        $c = getCourse($oC, $iC);

        return $iV * $c;
    }



    $inputValue = $_POST["inputValue"];
    $outputCurrency = $_POST["outputCurrency"];
    $inputCurrency = $_POST["inputCurrency"];

    $_SESSION["inputValue"] = $inputValue;
    $_SESSION["outputValue"] = convert($inputValue, $outputCurrency, $inputCurrency);
    $_SESSION["outputCurrency"] = $outputCurrency;
    $_SESSION["inputCurrency"] = $inputCurrency;

    if (!empty($_COOKIE["username"])) {

        $mysqli = new mysqli("localhost", "root", "", "mydb", 1234);

        $_u = $_COOKIE['username'];

        $user = mysqli_fetch_array(mysqli_query($mysqli, "SELECT id FROM `user` WHERE username = '{$_u}'"))[0];
        $currency = $_SESSION["inputCurrency"] . $_SESSION["outputCurrency"];
        $inV = $_SESSION["inputValue"];
        $outV = $_SESSION["outputValue"];

        $addNewNode = "INSERT INTO `conv` (user, currency, inV, outV) VALUES ('$user', '$currency', '$inV', '$outV')";
        mysqli_query($mysqli, $addNewNode);
    }

    redirect("main.php");