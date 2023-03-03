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
                    $stmt->bindValue(":id_login", $_GET["id_user"]);
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        echo "-----------------";
                        echo "<h4> Сообщение пользователю : " . get_name_by_id($conn,$row["id_recipient"]) . "</h4>";
                        echo "<h3> Тема : " . $row["title_message"] . "</h3>";
                        echo "<p> Текст : " . $row["text_message"] . "</p>";
                        echo "<br>";
                        echo "<a href='http://test/www/admin/del_message.php?id_message=".$row["Id"] ."&id_user=".$_GET["id_user"]. "'>удалить сообщение</a>";
                        echo "<br>";
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
                    $stmt->bindValue(":id_recipient", $_GET["id_user"]);
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        echo "-----------------";
                        echo "<h4> Сообщение от пользователя : " . get_name_by_id($conn,$row["id_sender"]) . "</h4>";
                        echo "<h3> Тема : " . $row["title_message"] . "</h3>";
                        echo "<p> Текст : " . $row["text_message"] . "</p>";
                        echo "<a href='http://test/www/admin/del_message.php?id_message=".$row["Id"] ."&id_user=".$_GET["id_user"]. "'>удалить сообщение</a>";
                        echo "<br>";
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