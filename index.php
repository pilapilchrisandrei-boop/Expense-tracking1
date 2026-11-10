<?php

    require_once "config.php";

    function h($str){
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $uname = $_POST['uname'];
        $password = $_POST['pword'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param('s',$uname); 
        $stmt->execute();

        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

        $stmt->close();

        if($user && $password === $user['password']){
            if($user['status'] !== "approved"){
                $errors[] = "Your account has not been approved by the admin";
            }else{
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header('Location: dashboard.php');

                exit;
            }           
        }else{
            $errors[] = "Incorrect username or password. Please try again.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Sign in</title>
</head>
<body>
    <h1>Expense tracking</h1>
    <h2>Sign In Account</h2>
    <br>

    <?php foreach($errors as $e): ?>
        <p style="color: red;"><?= h($e)?></p>

    <?php endforeach?>   

    <form action="" method="post">

        <label for="username">Username:</label>
        <input type="text" id="username" name="uname"
               placeholder="Enter your username" required autofocus>

        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="pword"
               placeholder="Enter your password" required>

        <br><br>

        <input type="submit" value="Sign In">

    </form>
       <br><br>
       <p>No Account? <a href="register.php">Register</a></p>

</body>
</html>