<?php 
    require './functions/functions.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_POST['username']);  
        $email = htmlspecialchars($_POST['email']);  
        $password_hash = htmlspecialchars($_POST['password_hash']);  
    
    
        createUser($username, $email, $password_hash);
    };

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    <style>

        main{
            margin: 200px auto;
            display: flex;
            flex-direction: column;
            gap: 40px;

            padding: 50px;
            background: #000;
            color: #fff;

            width: 600px;
        }

        .logotype{
            font-size: 30px;
            font-weight: 800;

            text-align: center;
        
        }

        #myform{
            display: flex;
            flex-direction: column;
            
        }

        label{
            margin-top: 20px;
        }

        .btn{
            margin-top: 20px;
            width: 100px;
            margin-left: 260px;
        }

    </style>
</head>
<body>

    <header>
        <nav>
            <a href="/index.php" class="reg">Регистрация</a>
            <a href="/login.php" class="login">Вход</a>
            <a href="/edit_profile.php" class="edit">Редактирование профиля</a>
            <a href="/admin.php" class="adm">Админ</a>
        </nav>
    </header>

    <main>

        <h1 class="logotype">Регистраця</h1>

        <form action="" method="post" id="myform">

            <label for="username">Имя:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Эл. почта:</label>
            <input type="email" name="email" id="email" required>

            <label for="password_hash">Пароль:</label>
            <input type="password" name="password_hash" id="password_hash" required>

            <input type="submit" class="btn">

        </form>

    </main>

</body>
</html>