<?php
require 'connect.php';
$sql = "SELECT * FROM users";   
$result = $db->prepare($sql);
$result->execute();
$value=$result->fetchAll();

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
            <?php endforeach ?>
        </tr>
    </table>
    </form>
</body>

</html>


