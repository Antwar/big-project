<?php 
    session_start();
    $_SERVER['link'] = mysqli_connect("151.248.115.10:3306", "root", "Kwuy1mSu4Y", "is64_Root");

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
        }
        echo 'Неверный email';
        
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
                $token = bin2hex(random_bytes(16));
                $token_query = "INSERT INTO sessions (user_id, token) VALUES ('" . $user['id'] . "', '$token')";
                mysqli_query($_SERVER['link'], $token_query);

                $_SESSION['token'] = $token;

                if ($email === 'admin@admin') {
                    header('Location: admin.php');
                } else {
                    header('Location: edit_profile.php');
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
        }

        echo 'Невалидный email';

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


?>