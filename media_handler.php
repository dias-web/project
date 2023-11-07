<?php
session_start();

require 'functions.php';
require 'db.php';

$pdo = getPDO();

$user_id =  $_SESSION['user']['id'];

$is_admin = is_admin(get_auth_user());

$fileName = uploadImage($_FILES['image']);

if ($is_admin) {

    $user_id_to_edit = $_GET['user_id_to_edit'];
    upload_avatar($fileName, $user_id_to_edit, $pdo);
} else {

    upload_avatar($fileName, $user_id, $pdo);
}


set_flash_message('success', 'Профиль успешно обновлен!');

$user = get_user_by_id($_GET['user_id_to_edit'], $pdo);

redirect_to("page_profile.php?user_id=" . $user['id']);


