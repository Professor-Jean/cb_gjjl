<?php
    $server_name = $_SERVER['SERVER_NAME'];
    $project_name = "cb_gjjl";
    define("BASE_URL", "http://".$server_name.DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR);
    include "authentication/cb_session_authentication.php";
    include "authentication/cb_permission_authentication.php";
?>