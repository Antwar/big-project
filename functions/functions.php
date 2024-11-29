<?php 
    session_start();
    $_SERVER['link'] = mysqli_connect("151.248.115.10", "root", "Kwuy1mSu4Y", "is64_Root");

    function createUser ($username, $email, $password_hash){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try{
                $query = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($_SERVER['link'], $query);
                
        
                $password = password_hash($password_hash, PASSWORD_DEFAULT);
        
                $create = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
                $result1 = mysqli_query($_SERVER['link'], $create);
        
                if ($result1) {
                    echo "Пользователь успешно добавлен.";
        
                } else {
                    throw new Exception("Ошибка");
                }
                }
                catch (Exception $e) {
                    echo "Пользователь с таким email уже зарегистрирован";
                }
        } else {

            echo 'Неверный email';

        }
        
    }

    function loginUser($email, $password_hash) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $email_result = mysqli_query($_SERVER['link'], $query);
    
        if (mysqli_num_rows($email_result) == 1) {
            $user = mysqli_fetch_assoc($email_result); 
            $hashed_password = $user['password'];
    
            if (password_verify($password_hash, $hashed_password)) {
                echo 'Вход успешен';
                $_SESSION['user_id'] = $user['id'];
                $session_token = bin2hex(random_bytes(16));
                $token_query = "INSERT INTO sessions (user_id, session_token) VALUES ('" . $user['id'] . "', '$session_token')";
                mysqli_query($_SERVER['link'], $token_query);
    
                $_SESSION['session_token'] = $session_token;
    
                if ($email === 'admin@admin.com') {
                    header('Location: admin.php');
                } else {
                    header('Location: create_post.php');
                }
                exit();
            } else {
                echo 'Неверный логин или пароль';
            }
        } else {
            echo 'Неверный логин или пароль';
        }
    
        mysqli_free_result($email_result);
    }

    function editProfile($user_id, $username, $email, $password_hash, $new_password_hash) {
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $query = "SELECT * FROM users WHERE id = '$user_id'";
            $result = mysqli_query($_SERVER['link'], $query);
            $user = mysqli_fetch_assoc($result);
            
    
            if (password_verify($password_hash, $user['password'])) {
                $update = "UPDATE users SET username = '$username', email = '$email' WHERE id = '$user_id'";
                
                if (!empty($new_password_hash)) {
                    $hashed_password = password_hash($new_password_hash, PASSWORD_DEFAULT);
                    $update = "UPDATE users SET username = '$username', email = '$email', password = '$hashed_password' WHERE id = '$user_id'";
                }
        
                $update_result = mysqli_query($_SERVER['link'], $update);
                
                return $update_result;
            } 
    
            mysqli_free_result($result);

        } else {

            echo 'Невалидный email';

        }

    }

    function getUsers () {
        $query = "SELECT username, email FROM users";
        $result = mysqli_query($_SERVER['link'], $query);

        $users = [];
        
        while ($someUser = mysqli_fetch_assoc($result)){
            $users[] = $someUser;
        }

        return $users;

        mysqli_free_result($result);
    }

    function generateToken ($email) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($_SERVER['link'], $query);

            if (mysqli_num_rows($result) == 1) {
                
                $user = mysqli_fetch_assoc($result);
                $token = bin2hex(random_bytes(6));
                $created_at = date('Y-m-d H:i:s');
                $expired_at = date('Y-m-d H:i:s', strtotime('+3 minutes'));
                $token_query = "INSERT INTO password_reset_tokens (user_id, token, created_at, expired_at) VALUES ('" . $user['id'] . "', '$token', '$created_at', '$expired_at')";
                mysqli_query($_SERVER['link'], $token_query);
                $_SESSION['email'] = $email;

            } else {
                echo 'Пользователь не найден';
            }
        } else {
            echo 'Невалидный email';
        }

    }

    function validateToken ($email, $token) {

        $query = "SELECT * FROM password_reset_tokens WHERE user_id = (SELECT id FROM users WHERE email = '$email') AND token = '$token' AND expired_at > NOW()";
        $result = mysqli_query($_SERVER['link'], $query);
        $exp_time = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1) {
            if ($exp_time['expired_at']) {
                
            }
        }

    }

    function resetPassword ($email, $token, $new_password_hash) {

        if (validateToken($email, $token)) {
            $hashed_password = password_hash($new_password_hash, PASSWORD_DEFAULT);
            $update = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
            mysqli_query($_SERVER['link'], $update);
            $delete_token = "DELETE FROM password_reset_tokens WHERE user_id = (SELECT id FROM users WHERE email = '$email')";
            mysqli_query($_SERVER['link'], $delete_token);
            echo 'Пароль успешно сброшен';
        } else {
            echo 'Токен недействителен';
        }
    }

    function createPost ($title, $content) {

        if ($title && $content) {

            $user_id = $_SESSION['user_id'];
            $created_at = date('Y-m-d H:i:s');

            $query = "INSERT INTO posts (user_id, title, content, created_at) VALUES ('$user_id' ,'$title', '$content', '$created_at')";
            mysqli_query($_SERVER['link'], $query);
            echo 'Пост успешно создан';
        
        } else {
            echo 'Заполните все поля';
        }

    }

    function getPosts () {

        $query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username FROM posts inner join users on posts.user_id = users.id"; 
        $result = mysqli_query($_SERVER['link'], $query);

        $posts = [];
        
        while ($somePost = mysqli_fetch_assoc($result)){
            $posts[] = $somePost;
        }

        return $posts;

    }

    function allUserPosts ($user_id) {

        $query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username FROM posts 
        inner join users on posts.user_id = users.id
        WHERE posts.user_id = '$user_id'"; 
        $result = mysqli_query($_SERVER['link'], $query);

        $posts = [];
        
        while ($somePost = mysqli_fetch_assoc($result)){
            $posts[] = $somePost;
        }

        return $posts;
    }

    function updatePost ($post_id ,$new_title, $new_content) {

        $query = "UPDATE posts SET title = '$new_title', content = '$new_content' WHERE id = '$post_id'";
        $result = mysqli_query($_SERVER['link'], $query);

        if ($result) {
            echo 'Успешно';
         } else {
            echo 'Неуспешно';
         }
    }

    function delPost ($post_id) {

            $query = "DELETE FROM posts WHERE id = '$post_id'";
            $result = mysqli_query($_SERVER['link'], $query);

            if ($result) {
                echo 'Пост удалён';
                header('Refresh: 1');
            } else {
                echo 'Произошла ошибка';
            }

    }

?>