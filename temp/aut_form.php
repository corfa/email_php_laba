<!DOCTYPE html>
<?php 
require_once(realpath('../config.php'));
?>
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
if(isset($_POST["sing_in"])){
    try{
        $conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
        $sql = "SELECT * FROM Users WHERE username = :login";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":login", $_POST["login"]);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        foreach ($stmt as $row) {
            if ($row["password"]==$_POST["password"]){
                setcookie("id", $row["id"],time()+60*60*24, "/");
                header("Location: http://test/www/main.php");

            }
            else{
                echo "неверный пароль";                
            }
        }
    
    }
    else{
        echo "такого нет";
    }


    
    }
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

?>
<h1>Войти как пользовтель</h1>
<form method="POST">
    <p>Логин: <input type="text" name="login" /></p>
    <p>Пароль: <input type="password" name="password" /></p>
    <input type="submit" value="Войти" name="sing_in">
</form>
<br>
<br>


<?php 
if(isset($_POST["sing_in_admin"])){
    try{
        $conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
        $sql = "SELECT * FROM admins WHERE login = :login_admin";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":login_admin", $_POST["login_admin"]);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        foreach ($stmt as $row) {
            if ($row["password"]==$_POST["password_admin"]){
                setcookie("admin", $row["login"],time()+60*60*24, "/");
                header("Location: http://test/www/admin/main_admin.php");
            }
            else{
                echo "неверный пароль";                
            }
        }
    
    }
    else{
        echo "такого нет";
    }


    // echo $row["username"];
   
    
    }
    catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}


?>
<h1>Войти как администратор</h1> 
<form method="POST">
    <p>Логин Админа: <input type="text" name="login_admin" /></p>
    <p>Пароль Админа: <input type="password" name="password_admin" /></p>
    <input type="submit" value="Войти" name="sing_in_admin">
</form>
<h2><a href="http://test/www/temp/create_form.php">создать пользователя</a></h2>
</body>
</html>