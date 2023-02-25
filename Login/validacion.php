<?php
require_once("../global/ConfigServer.php");
require_once("../global/connection_DB.php");
session_start();
function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//   if ($_SERVER["REQUEST_METHOD"]== "POST") {
if (!empty($_POST['name_user']) && !empty($_POST['pass_user'])) {

    $adminname = testInput($_POST["name_user"]);
    $password = testInput($_POST["pass_user"]);
    $stmt = $pdo->prepare("SELECT * FROM user_tbl WHERE name_user = :nameuser");
    $stmt->bindParam("nameuser", $adminname, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $passBD = $result['pass_user'];


    if (!$result) {
        header("location: login.php?fallo=true");
    } else {
        if (($result['name_user'] == $adminname)) {
            if (password_verify($password, $passBD)) {
                $user_id = $result['user_id'];
                $_SESSION['current_user_id'] = $user_id;
                $user_level = $result['type_user'];
                $_SESSION['current_user_type'] = $user_level;
                $_SESSION['current_user_name'] = $adminname;
                header("Location: ../Inventario/Dashboard.php");
            } else {
                header("location: login.php?fallo=true");
            }
        } else {
            header("location: login.php?fallo=true");
        }
    }
}
