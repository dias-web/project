<?php
session_start();

require 'functions.php';
require 'db.php';

$pdo = getPDO();

$email = $_POST['email'];
$password = $_POST['password'];

$is_admin = is_admin(get_auth_user());

if ($is_admin) {
    // Если пользователь - админ, то получите идентификатор пользователя, который должен быть отредактирован
    $user_id_to_edit = $_GET['user_id_to_edit'];

    // Проверьте, что user_id_to_edit действительно существует и не пустой
    if (empty($user_id_to_edit)) {
        set_flash_message('danger', 'Не удалось найти пользователя для редактирования.');
        redirect_to('security.php');
    }

    // Ваши проверки и обновление данных
    edit_credentials($email, $password, $user_id_to_edit, $pdo);

    set_flash_message('success', 'Профиль успешно обновлен!');

    // После успешного обновления перенаправьтесь на профиль редактируемого пользователя
    redirect_to("/page_profile.php?user_id=" . $user_id_to_edit);
} else {
    // Если пользователь не является админом, редактируйте свой собственный профиль
    $user_id =  $_SESSION['user']['id'];

    // Ваши проверки и обновление данных
    edit_credentials($email, $password, $user_id, $pdo);

    set_flash_message('success', 'Профиль успешно обновлен!');

    // После успешного обновления перенаправьтесь на свой профиль
    redirect_to("/page_profile.php?user_id=" . $user_id);
}
?>
