<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

<?php
// show session success message
$success_message = ['add_user', 'update_user', 'delete_user'];
foreach($success_message as $message){
    if(isset($_SESSION[$message])){
        echo "<div class='message success'>" . htmlspecialchars($_SESSION[$message]) . "</div>";
        unset($_SESSION[$message]);
    }
}
// show session error message
$error_message = ['e_get_user', 'e_add_user', 'e_update_user', 'e_delete_user'];
foreach($error_message as $message){
    if(isset($_SESSION[$message])){
        echo "<div class='message error'>" . htmlspecialchars($_SESSION[$message]) . "</div>";
        unset($_SESSION[$message]);
    }
}
?>

<div class="all_users_table">
    <h1>User Management</h1>
    <div class="navbar">
        <span class="toggleButton" data-form="getForm" title="get-user">🔍</span>
        <span class="toggleButton" data-form="addForm" title="add-user">➕</span>
        <span class="toggleButton" data-form="updForm" title="update-user">🔄</span>
    </div>
    
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Action</td>
            </tr>
        </thead>

        <tbody>
            <?php if(!isset($getAllUsers['error']) && isset($getAllUsers)): ?>
                <?php foreach ($getAllUsers as $user): ?>

                   <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <a href="?du=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                   </tr>
            
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td><?php echo $getAllUsers['error']; ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if(isset($back)) echo '<a href="'.htmlspecialchars($_SERVER['PHP_SELF']).'">Back</a>'; ?>
</div>

<div id="getForm" class="form">
    <h2>Get User</h2>
    <form method="post" action="">
        <label>id:</label>
        <input type="number" name="id" required><br><br>
        <button type="submit" name="getUser">Add User</button>
    </form>
</div>

<div id="addForm" class="form">
    <h2>Add new User</h2>
    <form method="post" action="">
        <label>name:</label>
        <input type="text" name="name" required><br><br>
        <label>email:</label>
        <input type="email" name="email" required><br><br>
        <button type="submit" name="addUser">Add User</button>
    </form>
</div>

<div id="updForm" class="form">
    <h2>Update User</h2>
    <form method="post" action="">
        <label>id:</label>
        <input type="number" name="id" required><br><br>
        <label>name:</label>
        <input type="text" name="name" required><br><br>
        <label>email:</label>
        <input type="email" name="email" required><br><br>
        <button type="submit" name="updUser">Add User</button>
    </form>
</div>

<script src="./assets/script.js"></script>
</body>
</html>
