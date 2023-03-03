<?php 
require_once(realpath('../config.php'));
?>
<?php 

$user_id = $_GET["id_user"];
$conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
$sql = "SELECT * FROM users WHERE id = :id_user";
$stmt = $conn->prepare($sql);
$stmt->bindValue(":id_user", $user_id );
$stmt->execute();

    foreach ($stmt as $row) {
        $login_user = $row["username"];
        $password_user = $row["password"];

    }
if (isset($_POST["update_data"])){
    $sql = "UPDATE users SET username = :new_username WHERE id = :id_user;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id_user", $user_id);
    $stmt->bindValue(":new_username", $_POST["update_login"]);
    $stmt->execute();
    $sql = "UPDATE users SET password = :new_password WHERE id = :id_user;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id_user", $user_id);
    $stmt->bindValue(":new_password", $_POST["update_password"]);
    $stmt->execute();
    header("Location: http://test/www/admin/main_admin.php");
}



echo "<form method='POST'>
<p>Логин Пользователя: <input type='text' name='update_login' value=$login_user /></p>
<p>Пароль Пользователя: <input type='text' name='update_password' value=$password_user /></p>
<input type='submit' value='изменить' name='update_data'>
</form>"

?>