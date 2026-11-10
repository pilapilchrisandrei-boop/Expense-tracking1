
<?php

    require_once "config.php";

    function h($str){
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }

    $mess = [];
    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $uname = $_POST['uname'];
        $password = $_POST['pword'];
        $password2 = $_POST['pword2'];

        if($password === $password2){
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES(?,?)");
            $stmt->bind_param('ss',$uname,$password);
            $stmt->execute();

            if($stmt){
                $mess[] = "registered successfully. Please wait for the admin approval of your account.";
            }else{
                $errors[] = "Something went wrong. Please try again later.";
            }
        }else{
            $errors[] = "Password should match";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Expense tracking</h1>
    <h2>Create Account</h2>
    <br>

    <?php foreach($errors as $e): ?>
        <p style="color: pink;"><?= h($e)?></p>
    <?php endforeach?>

    <br>

    <?php foreach($mess as $m): ?>
        <p style="color: blue;"><?= h($m)?></p>
    <?php endforeach?>

    <form action="" method="post">

        <label for="username">Username:</label>
        <input type="text" id="username" name="uname"
               placeholder="Enter username" required autofocus>

        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="pword"
               placeholder="Enter password" required>

        <br><br>

        <label for="password2">Confirm Password:</label>
        <input type="password" id="password2" name="pword2"
               placeholder="Confirm Password" required>

        <br><br>

        <input type="submit" value="Register">

    </form>

    <br><br>

    <p>Already Have an Account? <a href="index.php">Sign In</a></p>

</body>
</html>