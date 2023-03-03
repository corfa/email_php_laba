<?php 
require_once(realpath('../config.php'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
if(isset($_POST["subm"])){
    try{
    $login = $_POST["login"];
    $password = $_POST["password"];
    $conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);


    $sql = "INSERT INTO Users (username, password) VALUES ('$login', $password)";
    $res = $conn->exec($sql);
    if ($res==1){
        header("Location: http://test/www/temp/aut_form.php");
    }
    
    else {
        
        echo "Попробуй другой логин :(";
    }
    
    }
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
    <h1>Регистрация</h1>
    <form method="POST">
    <p>Логин: <input type="text" name="login" /></p>
    <p>Пароль: <input type="password" name="password" /></p>
    <input type="submit" value="Зарегестрироватся" name="subm">

</form>

</body>
</html>