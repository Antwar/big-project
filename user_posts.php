<?php 
require './functions/functions.php';

if (isset($_SESSION['session_token']) && $_SESSION['user_id']) {

    echo '<style> .reg, .login, .adm {visibility: hidden;} </style>';
} else {
    header('Location: login.php');
}

$user_id = $_SESSION['user_id'];

$posts = allUserPosts($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['del_post']) && isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
        delPost($post_id);
    } elseif (isset($_POST['edit_post'])) {
        $post_id = $_POST['post_id'];
        header('Location: update_post.php?post_id=' . $post_id);
    }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your posts</title>

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

        <h1 class="all-users-heading">Ваши посты</h1>

        <div class="all-users">

            <?php if (empty($posts)): ?> 
                <span>Нет постов</span>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="card">

                        <h3>Заголовок: <?php echo htmlspecialchars($post['title']) ?></h3>
                        <h3>Содержание: <?php echo htmlspecialchars($post['content']) ?></h3>
                        <h3>Имя автора: <?php echo htmlspecialchars($post['username']) ?></h3>
                        <h3>Дата и время создания: <?php echo htmlspecialchars($post['created_at']) ?></h3>

                        <form action="" method="post">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit" name="edit_post">Редактировать</button>
                        </form>

                        <form action="" method="post">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit" name="del_post">Удалить</button>
                        </form>

                    </div>
                <?php endforeach ?>
            <?php endif ?>

        </div>

    </main>
    
</body>
</html>