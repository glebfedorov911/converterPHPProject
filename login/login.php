<?php

    $title = "Вход";

    session_start();
    $root = $_SERVER["DOCUMENT_ROOT"];

    require $root . "/html/header.php";
    require $root . "/other/other.php";

    $opt = ["usernameError", "passwordError", "password", "username"];

    checkSession($opt);

    if (!empty($_COOKIE["username"])) {

        header("Location: ../main.php");

    }

?>

<h1>ВХОД</h1>

<form action="save_login.php" method="post">

    <label for="username">Логин:</label>
    <input type="text" name="username" value="<?=$_SESSION["username"]?>">
    <div class="usernameError"> <?=$_SESSION["usernameError"]?> </div><br>
    <label for="password">Пароль:</label>
    <input type="password" name="password" value="<?=$_SESSION["password"]?>" >
    <div class="passwordError"> <?=$_SESSION["passwordError"]?> </div><br>
    <button type="submit">Отправить</button>

</form>


<?php

    include $root . "/html/footer.php";