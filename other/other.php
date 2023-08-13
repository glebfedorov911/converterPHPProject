<?php
    function checkSession($opt) {
        foreach ($opt as $item) {
            if (empty($_SESSION[$item])) {
                $_SESSION[$item] = "";
            }
        }
    }

    function redirect($page) {
        header("Location: $page", true,  301);
        exit;
    }