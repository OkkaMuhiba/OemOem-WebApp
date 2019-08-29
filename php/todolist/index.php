<?php
    require_once "./../config/db.php";
    $lists = NULL;
    $dones = NULL;
    
    if($conn != NULL){               
        if(isset($_POST["todolist"])){            
            $todo = $_POST["todolist"];
            $query = $conn->prepare("INSERT INTO todolists(todo, status) VALUES ( :todo , false)");
            $query->bindParam(':todo', $todo, PDO::PARAM_STR);
            $query->execute();
        }        

        if(isset($_GET["update"])){
            $id = $_GET["update"];
            $query = $conn->prepare("UPDATE todolists SET status = true WHERE id = :id");
            $query->bindParam(":id", $id);
            $query->execute();
        }

        if(isset($_GET["delete"])){
            $id = $_GET["delete"];
            $query = $conn->prepare("DELETE FROM todolists where id = :id");
            $query->bindParam(":id", $id);
            $query->execute();
        }
    } else {
        $lists = [];
        $dones = [];
    }

    header("Location: ./../index.php");
?>