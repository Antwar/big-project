<?php 
require './functions/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $post = createPost($title, $content);
}


if (isset($_SESSION['session_token']) && $_SESSION['user_id']) {
    echo '<style> .reg, .login, .adm {visibility: hidden;} </style>';
} else {
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create post</title>

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
            <a href="/create_post.php">Создать пост</a>
            <a href="/all_posts.php">Просмотр постов</a>
            <a href="/user_posts.php">Ваши посты</a>

            <form action="./functions/logout.php" method="post">
                <button type="submit">Выйти из аккаунта</button>
            </form>

        </nav>
    </header>

<main>
    <h1 class="logotype">Создание поста</h1>

    <form action="" method="post" id="myform">
        <label for="title">Заголовок:</label>
        <input type="text" name="title" id="title" required>

        <label for="content">Содержание:</label>
        <input type="text" name="content" id="content" required>

        <input type="submit" class="btn" value="Создать">

    </form>
</main>

</body>
</html>