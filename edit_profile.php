<?php 
require './functions/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_hash = $_POST['password_hash'];
    $new_password_hash = isset($_POST['new_password_hash']) ? $_POST['new_password_hash'] : '';

    if (empty($password_hash)) {
        echo 'Введите текущий пароль';
    } else {
        $upd = editProfile($user_id, $username, $email, $password_hash, $new_password_hash);

        if ($upd) {
            echo 'Изменения внесены';
        } else {
            echo 'Изменения не внесены';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>

    <style>
        main {
            margin: 200px auto;
            display: flex;
            flex-direction: column;
            gap: 40px;
            padding: 50px;
            background: #000;
            color: #fff;
            width: 600px;
        }

        .logotype {
            font-size: 30px;
            font-weight: 800;
            text-align: center;
        }

        #myform {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 20px;
        }

        .btn {
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
    <h1 class="logotype">Редактирование</h1>

    <form action="" method="post" id="myform">
        <label for="username">Имя:</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Эл. почта:</label>
        <input type="email" name="email" id="email" required>

        <label for="password_hash">Текущий пароль:</label>
        <input type="password" name="password_hash" id="password_hash" required>

        <label for="new_password_hash">Новый пароль:</label>
        <input type="password" name="new_password_hash" id="new_password_hash" placeholder="Не заполняйте, если не хотите менять">

        <input type="submit" class="btn" value="Сохранить">
    </form>
</main>

</body>
</html>