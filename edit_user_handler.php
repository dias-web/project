<?php
session_start();

require 'functions.php';
require 'db.php';

$pdo = getPDO();

$username = $_POST['username'];
$job = $_POST['job'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$data = [
    ':username' => $username,
    ':job_title' => $job,
    ':phone' => $phone,
    ':address' => $address,
];

$user_id =  $_SESSION['user']['id'];

$is_admin = is_admin(get_auth_user());

if ($is_admin) {
    // Если пользователь - админ, то получите идентификатор пользователя, который должен быть отредактирован
    $user_id_to_edit = $_GET['user_id_to_edit'];
    change_user_info($data, $user_id_to_edit, $pdo);
} else {
    // Если пользователь не является админом, редактируйте свой собственный профиль
    change_user_info($data, $user_id, $pdo);
}

set_flash_message('success', 'Профиль успешно обновлен!');

$user = get_user_by_id($_GET['user_id_to_edit'], $pdo);

redirect_to("edit.php?user_id=" . $user['id']);

