<!DOCTYPE html>
<?php 
require_once(realpath('config.php'));
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
if ($_COOKIE["id"]){
    
}
else{
    header("Location: http://test/www/error/error.php");
}


?>
<body>
    <?php
    if(isset($_POST["send_message"])){
        try{
        $sender_id = $_COOKIE["id"]; 
        $title = $_POST["title"];
        $text_message = $_POST["text_message"];
        $recipient = $_POST["recipient"];
        $conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
        $sql = "SELECT * FROM Users WHERE username = :recipient";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":recipient",$recipient);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            foreach ($stmt as $row) {
                $recipient_id = $row["id"];
            }
            $sql = "INSERT INTO email_messages (id_sender,id_recipient,text_message,title_message) VALUES ('$sender_id', '$recipient_id', '$text_message','$title')";
            $res = $conn->exec($sql);


        
        }
        else{
            echo "нет такого получателя!";
        }     
         }
        catch (PDOException $e) {
            echo "что то пошло не так :(" . $e->getMessage();
        }
    }
    ?>

<div style="float:right">
<?php

$conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
$sql = "SELECT * FROM Users WHERE id = :log_id";
 $stmt = $conn->prepare($sql);
 $stmt->bindValue(":log_id", $_COOKIE["id"]);
 $stmt->execute();
     foreach ($stmt as $row) {
         $login = $row["username"];
     }
     echo "<h1> Вы зашли под пользователем :  $login </h1>";
?>
<br>
<?php 
 if(isset($_POST["exit"])){
    setcookie("id", -1,time()-60*60*24, "/");
    header("Location: http://test/www/temp/aut_form.php");
}

?>
<form method="POST">
<input type="submit" value="выйти" name="exit">
</form>
</div>
    
<h1>Написать сообщение</h1>
    <div style="margin-bottom: 50px; border: solid;   display: inline-block; padding:10px">
    <form method="POST">
    <p>логин получателя: <input type="text" name="recipient" /></p>
    <p>Заголовок: <input type="text" name="title" /></p>
    <p>текст письма: <textarea name="text_message"> </textarea></p>
    <input type="submit" value="отправить" name="send_message">
    </form>
    </div>
    <br>
     
    <div style="margin-right: 150px; float: right;overflow-y: scroll; height: 400px; width: 600px; border: 1px solid;">
    <h1>Отправленные</h1>
    <?php
    function get_name_by_id($connect,$id_recipient)
    {
        $sql = "SELECT * FROM users WHERE id = :id_recipient";
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(":id_recipient", $id_recipient);
        $stmt->execute();
        foreach ($stmt as $row) {
        return $row["username"];
        }
    }
    
        try {
            $conn = new PDO("mysql:host=$HOST_DB;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
                    $sql = "SELECT * FROM email_messages WHERE id_sender = :id_login";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(":id_login", $_COOKIE["id"]);
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        echo "-----------------";
                        echo "<h4> Сообщение пользователю : " . get_name_by_id($conn,$row["id_recipient"]) . "</h4>";
                        echo "<h3> Тема : " . $row["title_message"] . "</h3>";
                        echo "<p> Текст : " . $row["text_message"] . "</p>";
                       echo "-----------------";

                    }
                    
                    
                           
            
                        
        }
        catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    
    ?>
    </div>
     
     <div style="margin-left: 150px; float: left; overflow-y: scroll; height: 400px; width: 600px; border: 1px solid;">
     <h1>Полученные</h1>
        <?php
    
        try {
                    $sql = "SELECT * FROM email_messages WHERE id_recipient = :id_recipient";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(":id_recipient", $_COOKIE["id"]);
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        echo "-----------------";
                        echo "<h4> Сообщение от пользователя : " . get_name_by_id($conn,$row["id_sender"]) . "</h4>";
                        echo "<h3> Тема : " . $row["title_message"] . "</h3>";
                        echo "<p> Текст : " . $row["text_message"] . "</p>";
                       echo "-----------------";

                    }
                    
                    
                           
            
                        
        }
        catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    
        ?>
    </div>

</body>
<?php

?>
</html>