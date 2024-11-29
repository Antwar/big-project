<?php 
require './functions/functions.php';

if (isset($_SESSION['session_token']) && $_SESSION['user_id']) {
    echo '<style> .reg, .login, .adm {visibility: hidden;} </style>';
} else {
    header('Location: login.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_GET['post_id'];
    $new_title = htmlspecialchars($_POST['new_title']);
    $new_content = htmlspecialchars($_POST['new_content']);

    

    updatePost($post_id, $new_title, $new_content);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update post</title>

    <style>

        .all-users {
            display: flex;
            gap:20px;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: auto;
            height: auto;
            background-color: black;
            color: white;
            font-size: 14px;
            padding: 5px;
            min-width: 150px;
            max-width: 250px;
            overflow-wrap: break-word;
        }

    </style>

</head>
<body>

    <header>
        <nav>
            <a href="/index.php" class="reg">Регистрация</a>
            <a href="/login.php" class="login">Вход</a>
            <a href="/edit_profile.php" class="edit">Редактирование профиля</a>
            <?php if ($isAdmin): ?>
            <a href="/admin.php" class="adm">Админ</a>
            <?php endif; ?>
            <a href="/create_post.php">Создать пост</a>
            <a href="/all_posts.php">Просмотр постов</a>
            <a href="/user_posts.php">Ваши посты</a>

            <form action="./functions/logout.php" method="post">
                <button type="submit">Выйти из аккаунта</button>
            </form>

        </nav>
    </header>

    <main>

        <h1 class="all-users-heading">Редактирование поста</h1>

        <div class="all-users">

        <form action="" method="post" id="myform">

            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

            <label for="new_title">Новый заголовок</label>
            <input type="text" name="new_title" id="new_title" required>

            <label for="new_content">Новое содержание</label>
            <input type="text" name="new_content" id="new_content" required>


            <input type="submit" class="btn" value="Сохранить">

        </form>

        </div>

    </main>
    
</body>
</html>