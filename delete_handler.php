<?php
session_start();

require 'functions.php';
require 'db.php';

$pdo = getPDO();
$user_id = $_SESSION['user']['id'];
$is_admin = is_admin(get_auth_user());

if ($is_admin) {

    $user_id_to_delete = $_GET['user_id'];

    if ($user_id_to_delete != $user_id) {
        delete_user($user_id_to_delete, $pdo);
        set_flash_message('success', 'Пользователь удален!');

        if ($user_id_to_delete === $user_id) {
            delete_user($user_id, $pdo);
            set_flash_message('success', 'Пользователь удален!');
            unset($_SESSION['user']);
            redirect_to("page_register.php");
        }

    } else {

        delete_user($user_id, $pdo);
        set_flash_message('success', 'Пользователь удален!');
        unset($_SESSION['user']);
        redirect_to("page_register.php");
    }
}
?>
