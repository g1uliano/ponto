<?php

include_once("../../sca/inc/mysql.class.php");
include_once("controlePonto.php");
error_reporting(0);
session_start();

$controle = new controlePonto();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

if (@$_GET['destroy'] == 'session') {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    echo '..';
    exit;
}

if ($_GET['registrar'] == 'ponto') {
    if ($controle->registraPonto()) {
        if ($controle->getLastPontoEvent() == 'S') {
            echo '1';
        } else {
            echo '2';
        }
    } else {
        echo '3';
    }
}
?>
