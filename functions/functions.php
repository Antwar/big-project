<?php 
    session_start();
    $_SERVER['link'] = mysqli_connect("151.248.115.10:3306", "root", "Kwuy1mSu4Y", "is64_Root");

    function createUser ($username, $email, $password_hash){
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

    function loginUser($email, $password_hash) {

        $query = "SELECT * FROM users WHERE email = '$email'";
        $email_result = mysqli_query($_SERVER['link'], $query);
    
        if (mysqli_num_rows($email_result) == 1) {
            $user = mysqli_fetch_assoc($email_result); 
            $hashed_password = $user['password'];
    
            if (password_verify($password_hash, $hashed_password)) {
                echo 'Вход успешен';
                $_SESSION['user_id'] = $user['id'];
                sleep(0.1);
                header('Location: edit_profile.php');
            } else {
                echo 'Неверный логин или пароль';
            }
        } else {
            echo 'Неверный логин или пароль';
        }

    }

    function editProfile($user_id, $username, $email, $password_hash, $new_password_hash) {
        

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
    }



?>