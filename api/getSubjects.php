<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once('../database.php');
    require_once '../logger.php';
    global $logger;
    $mysqli = getConnection(1, 0);
    require(__DIR__ . "/getUserFromToken.php");
    $bruker = getUserFromToken($mysqli);

    if ($bruker) {
        $sql = $mysqli->prepare("CALL getUserSubjects(?)");
        $sql->bind_param("i",$bruker["user_id"]);
        $sql->execute();
        $subjects = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode($subjects);
    } else {
        if (isset($_POST["auth_token"])) {
            $logger->info("Error with token: " . isset($_POST["auth_token"]));
        }
    }
}
?>