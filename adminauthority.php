<?php

    require 'connect.php';

    $limit = 4;
    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
    }
    else
    {
        $page = 1;
    }

    $offset = ($page -1) * $limit;

    $sql = "SELECT * FROM users ORDER BY username LIMIT {$offset},{$limit}";   
    $result = $db->prepare($sql);
    $result->execute();
    $value=$result->fetchAll();

    $select = "SELECT * FROM users";
    $statement=$db->prepare($select);
    $statement->execute();
  
    if($statement->rowCount() >0)
    {
      $total_records = $statement->rowCount();
      $total_page = ceil($total_records/$limit);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Users</title>
    <link rel="stylesheet" href="admin.css" type="text/css">
</head>

<body>
    <h3>Click here to <a href="register.php">add a user</a></h3>
    <h3> <a href="homepage.php">Go to Home</a> </h3>
    <form action="adminauthority.php?id" method="post">
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        <?php foreach($value as $values):?>
        <tr>
            <td><?= $values['username'] ?></td>
            <td><?= $values['email'] ?></td>
            <td>
                <div>
                    <a href="edituser.php?id=<?=$values['id']?>">edit</a>
                </div>
            </td>
            <td>
                <div>
                    <button onclick="return confirm('Are you sure?')"><a href="deleteuser.php?id=<?=$values['id']?>">delete</a></button>
                </div>  
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    </form>


    <?php
        echo '<ul>';
        if($page >1)
        {
          echo  '<span><a href ="adminauthority.php?page='.($page- 1).'">Previous</a>-</span>';
        }

        for($i = 1; $i <=$total_page; $i++)
        {
          echo '<span><a href ="adminauthority.php?page='.$i.'">'.$i.'</a>-</span>';
        }

        if($total_page >$page)
        {
          echo '<span><a href ="adminauthority.php?page='.($page+ 1).'">Next</a></span>';
        }

        echo '</ul>';
      ?>
</body>
</html>



