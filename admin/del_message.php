<?php 
require_once(realpath('../config.php'));
?>
<?php
$conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
$sql = "DELETE FROM email_messages WHERE id=:id_mess;";
$stmt = $conn->prepare($sql);
$stmt->bindValue(":id_mess",  $_GET["id_message"]);
$stmt->execute();
header("Location: http://test/www/admin/show_user_message.php?id_user=".$_GET["id_user"]);
?>