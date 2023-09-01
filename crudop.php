<?php

session_start();

include "db_conn.php";

//Create a new user
if (isset($_POST['create']))
{
    $new_name = mysqli_real_escape_string($conn, $_POST['new_name']);
    $new_uname = mysqli_real_escape_string($conn, $_POST['new_uname']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
    $hashed_pass = md5($new_pass);
    $insert_query = "INSERT INTO users (name, user_name, password) VALUES ('$new_name', '$new_uname', '$hashed_pass')";
    mysqli_query($conn, $insert_query);
}

// Update an existing user
if (isset($_POST['update'])) 
{
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $updated_uname = mysqli_real_escape_string($conn, $_POST['updated_uname']);
    $updated_pass = mysqli_real_escape_string($conn, $_POST['updated_pass']);
    $hashed_pass = md5($updated_pass);
    $update_query = "UPDATE users SET user_name='$updated_uname', password='$hashed_pass' WHERE id=$user_id";
    mysqli_query($conn, $update_query);
}

// Delete a user
if (isset($_POST['delete'])) 
{
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $delete_query = "DELETE FROM users WHERE id=$user_id";
    mysqli_query($conn, $delete_query);
}

// Read users
$read_query = "SELECT * FROM users";
$result = mysqli_query($conn, $read_query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Example</title>
    <style>
        body 
        {
            font-family: Arial, sans-serif;
        }
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 25vh; /* Set to 100% viewport height */
        }
         .logout-link {
            text-decoration: none;
            padding: 8px 16px;
            background-color: #f2f2f2;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;

        }
    </style>
</head>
<body>
    <center><h2>CRUD Operations</h2></center>



<!-- Create User Form -->
<div class="form-container">
    <h3>Create User</h3>
    <form method="post" action="">
         <input type="text" name="new_name" placeholder="Name" required>
        <input type="text" name="new_uname" placeholder="Username" required>
        <input type="password" name="new_pass" placeholder="Password" required>
        <button type="submit" name="create" class="btn">Create</button>
    </form>
</div>

<!-- Users Table -->
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Password</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['user_name']; ?></td>
            <td><?php echo $user['password']; ?></td>
            <td>
                
                <form method="post" action="">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="text" name="updated_uname" placeholder="Updated Username">
                    <input type="password" name="updated_pass" placeholder="Updated Password">
                    <button type="submit" name="update" class="btn">Update</button>
                    <button type="submit" name="delete" class="btn">Delete</button>
                </form>
                 
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="center-container">
        <a href="index.php" class="logout-link">Logout</a>
    </div>


</body>
</html>
