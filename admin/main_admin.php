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
<?php 
if ($_COOKIE["admin"]){

}
else{
    header("Location: http://test/www/error/error.php");
}


?>
<body>
<?php 
 if(isset($_POST["exit"])){
    setcookie("admin", -1,time()-60*60*24, "/");
    header("Location: http://test/www/temp/aut_form.php");
}
?>
<form method="POST" style="float:right;">
<input type="submit" value="выйти" name="exit">
</form>


    <center>
    <div style="padding:50px; border: solid;   display: inline-block;">
        <h1>Все пользователи</h1>
    <?php 
            $conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);

        $sql = "SELECT * FROM Users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
            foreach ($stmt as $row) {
                echo "------------------";
                echo "<h3>". $row["username"] ."</h3>";
                echo "<a href='http://test/www/admin/show_user_message.php?id_user=".$row["id"] . "'>посмотреть сообщения пользователя</a>";
                echo "<br>";
                echo "<a href='http://test/www/admin/update_user.php?id_user=".$row["id"] . "'>изменить данные пользователя</a>";
                echo "<br>";
                echo "<a href='http://test/www/admin/del_user.php?id_user=".$row["id"] . "'>удалить пользователя</a>";
                echo "<br>";
               
            }
        
        
    
   
    
    ?>
</div>
        </center>
</body>
</html>