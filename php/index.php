
<?php
require_once "./config/db.php";
    $lists = NULL;
    $dones = NULL;

    if($conn != NULL){
        $query = $conn->prepare("SELECT * FROM todolists WHERE status = false");
        $query->execute();
        $lists = $query->fetchAll();        
        
        $query = $conn->prepare("SELECT * FROM todolists WHERE status = true");
        $query->execute();
        $dones = $query->fetchAll();
    } else {
        $lists = [];
        $dones = [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sebuah Kegabutan</title>
</head>
<body>
    <h1>Ini judul</h1>
    <h2>ini bisa dijadiin sub-judul</h2>
    <!-- Di bawah ini buat input to-do list -->
    <p>insert to-do list</p>
    <form action="/oemoem/todolist/" method="post">
        <input type="text" name="todolist" id="">
        <button type="submit">Submit</button>
    </form>
    <!-- akhir dari input to-do list -->

    <!-- Di bawah ini buat list to-do list -->
    <p>to-do list</p>
    <ul>
        <?php foreach($lists as $list): ?>
        <form action="/oemoem/todolist/" method="get">
            <input type="hidden" name="update" value ="<?php echo $list["id"]; ?>">
            <li><?php echo $list["todo"]; ?> | <input type="submit" value="Mark as Done"></li>
        </form>
        <?php endforeach; ?>
    </ul>
    <!-- akhir dari to-do list -->

    <!-- Ini buat list kegiatan yang dah dilakuin -->
    <p>Done!</p>
    <ul>
        <?php foreach($dones as $done): ?>
        <form action="/oemoem/todolist/" method="get">
            <input type="hidden" name="delete" value="<?php echo $done["id"] ?>">
            <li><?php echo $done['todo']; ?> | <input type="submit" value="Delete"></li>
        </form>
        <?php endforeach; ?>
    </ul>
    <!-- akhir dari kegiatan yang dah dilakuin -->
</body>
</html>