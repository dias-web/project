<?php

function get_user_by_email($email, $pdo) {

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function add_user($email, $password, $pdo) {
    $stmt = $pdo->prepare('INSERT INTO users(email, password) VALUES (:email, :password)');
    $stmt->execute([
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT)
    ]);
    return $pdo->lastInsertId();
}


function login($email, $password, $pdo) {

    $user = get_user_by_email($email, $pdo);

    if (empty($user) || !password_verify($password, $user['password'])) {
        return false;

    }

    $_SESSION['user'] = ['email' => $user['email'], 'id' => $user['id'], 'role' =>$user['role'] ];
    return true;

}

//function login() {
//    $user = [
//        'id' => 1,
//        'email' => 'john@example.com',
//        'role' => 'admin'
//    ];
//    $_SESSION['user'] = $user;
//}

function set_flash_message($name, $message) {
    $_SESSION[$name] = $message;
    return $_SESSION[$name];
}

function display_flash_message($name) {
     if(isset($_SESSION[$name])) {
         echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\"><strong>Уведомление! </strong>{$_SESSION[$name]}</div>";
         unset($_SESSION[$name]);
       }
}

function redirect_to($path) {
    header('Location:' . $path);
    exit();
}

function is_logged_in()
{
    if(isset($_SESSION['user'])) {
        return true;
    }
    return false;
}

function is_not_logged_in()
{
    return !is_logged_in();
}

function get_users($pdo)
{
    $stmt = $pdo->query('SELECT * FROM users');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_auth_user()
{
    if(is_logged_in()) {
        return $_SESSION['user'];
    }
    return false;
}

function is_admin($user)
{
    if(is_logged_in()) {
        if($user['role'] === 'admin') {
            return true;
        }
        return false;
    }
    return false;
}

function is_equal($user, $current_user)
{
    return $user['id'] === $current_user['id'];
}

function edit_user($username, $job, $phone, $address, $id, $pdo)
{

    $stmt = $pdo->prepare('UPDATE users SET username = :username, job_title = :job_title, phone = :phone, address = :address  WHERE id = :id');

    // Выполните обновление, используя предварительно подготовленный запрос
    $stmt->execute([
        ':username' => $username,
        ':job_title' => $job,
        ':phone' => $phone,
        ':address' => $address,
        ':id' => $id
    ]);
}

function set_status($status, $id, $pdo)
{
    $stmt = $pdo->prepare('UPDATE users SET status = :status WHERE id = :id');
    $stmt->execute([':status' => $status, ':id' => $id]);
}

function uploadImage($image)
{
    $filename = uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
    move_uploaded_file($image['tmp_name'], 'uploads/' . $filename);

    return $filename;
}

function upload_avatar($image, $id, $pdo)
{
    $stmt = $pdo->prepare('UPDATE users SET image = :image WHERE id = :id');
    $stmt->execute([':image' => $image, ':id' => $id]);
}

function add_social_links($vk, $telegram, $instagram, $id, $pdo)
{
    $stmt = $pdo->prepare('UPDATE users SET vk = :vk, telegram = :telegram, instagram = :instagram WHERE id = :id');
    $stmt->execute([
        ':vk' => $vk,
        ':telegram' => $telegram,
        ':instagram' => $instagram,
        ':id' => $id
    ]);
}

function get_user_by_id($id, $pdo)
{
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

