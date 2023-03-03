<?php 
require_once(realpath('../config.php'));
?>
<?php
$conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
$sql = "DELETE FROM email_messages WHERE id_sender=:id_usr;";
$stmt = $conn->prepare($sql);
$stmt->bindValue(":id_usr", $_GET["id_user"]);
$stmt->execute();
$sql = "DELETE FROM email_messages WHERE id_recipient=:id_usr;";
$stmt = $conn->prepare($sql);
$stmt->bindValue(":id_usr", $_GET["id_user"]);
$stmt->execute();
$sql = "DELETE FROM users WHERE id=:id_usr;";
$stmt = $conn->prepare($sql);
$stmt->bindValue(":id_usr", $_GET["id_user"]);
$stmt->execute();
header("Location: http://test/www/admin/main_admin.php");
?>