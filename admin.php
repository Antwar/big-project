<?php 
require './functions/functions.php';

$users = getUsers();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

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
        </nav>
    </header>

    <main>

        <h1 class="all-users-heading">Все пользователи</h1>

        <div class="all-users">

            <?php if (empty($users)): ?> 
                <span>Нет зарегистрированных пользователей</span>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <div class="card">

                        <h3>Имя: <?php echo htmlspecialchars($user['username']) ?></h3>
                        <h3>Email: <?php echo htmlspecialchars($user['email']) ?></h3>

                    </div>
                <?php endforeach ?>
            <?php endif ?>

        </div>

    </main>
    
</body>
</html>