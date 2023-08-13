<?php
    $title = "Главная страница";

    $root = $_SERVER["DOCUMENT_ROOT"];

    require $root . "/html/header.php";
    require $root . "/other/other.php";

    session_start();

    $opt = ["inputValue", "outputValue", "outputCurrency", "inputCurrency"];

    checkSession($opt);

    $root = $_SERVER["DOCUMENT_ROOT"];

    if (empty($_COOKIE["username"])) {
        $urlSignUp = "signUp/signUp.php";
        $urlLogin = "login/login.php";
        echo "<a href='$urlSignUp'>Регистрация</a>" . " | " . "<a href='$urlLogin'>Вход</a>";
    } else {
        $urlLogout = "login/logout.php";
        echo $_COOKIE["username"] . " | " . "<a href='$urlLogout'>Выход</a>";
    }
?>

<form action="save_course.php" method="post">
    <select name="inputCurrency" class="inputCurrency">
        <option value="USD">USD</option>
        <option value="RUB">RUB</option>
        <option value="EUR">EUR</option>
    </select>
    <input type="number" name="inputValue" class="inputValue" value="<?=$_SESSION['inputValue']?>" ><br>
    <select name="outputCurrency" class="outputCurrency">
        <option value="USD">USD</option>
        <option value="RUB">RUB</option>
        <option value="EUR">EUR</option>
    </select>
    <input type="number" name="outputValue" class="outputValue" disabled="disabled" value="<?=$_SESSION['outputValue']?>" ><br>
    <button type="submit">Конвертировать</button>
</form>

<script>
    let inputCurrency = "<?=$_SESSION["inputCurrency"]?>";
    let selectInp = document.querySelectorAll(".inputCurrency")[0];

    let outputCurrency = "<?=$_SESSION["outputCurrency"]?>";
    let selectOut = document.querySelectorAll(".outputCurrency")[0];

    function select(sel, cur) {
        for(let i = 0; i<sel.length; i++) {
            if (sel[i].innerText == cur) {
                sel.selectedIndex = i;
            }
        }
    }

    select(selectInp, inputCurrency);
    select(selectOut, outputCurrency);
</script>

<?php

    if (!empty($_COOKIE["username"])) {

        echo "<h1>Последние записи</h1>";

        $mysqli = new mysqli("localhost", "root", "", "mydb", 1234);

        $_u = $_COOKIE["username"];
        $user = mysqli_fetch_array(mysqli_query($mysqli, "SELECT id FROM `user` WHERE username = '{$_u}'"))[0];

        $result = mysqli_query($mysqli, "SELECT * FROM `conv` WHERE user = '{$user}'");

        for ($i = 0; $i<5; $i++) {
            $data = mysqli_fetch_array($result);
            echo "currency: " . $data["currency"] . " input value: " . $data["inV"] . " output value: " . $data["outV"] . "<br>";
        }

    }

    include $root . "/html/footer.php";