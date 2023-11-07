<?php
session_start();

require 'functions.php';
require 'db.php';

$pdo = getPDO();

$email = $_POST['email'];
$password = $_POST['password'];

$is_admin = is_admin(get_auth_user());

if ($is_admin) {

    $user_id_to_edit = $_GET['user_id_to_edit'];

    if (empty($user_id_to_edit)) {
        set_flash_message('danger', 'Не удалось найти пользователя для редактирования.');
        redirect_to('security.php');
    }

    edit_credentials($email, $password, $user_id_to_edit, $pdo);

    set_flash_message('success', 'Профиль успешно обновлен!');

    redirect_to("/page_profile.php?user_id=" . $user_id_to_edit);
} else {
    // Если пользователь не является админом, редактируйте свой собственный профиль
    $user_id =  $_SESSION['user']['id'];

    edit_credentials($email, $password, $user_id, $pdo);

    set_flash_message('success', 'Профиль успешно обновлен!');

    redirect_to("/page_profile.php?user_id=" . $user_id);
}
?>
